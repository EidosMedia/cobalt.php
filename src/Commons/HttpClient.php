<?php

namespace Eidosmedia\Cobalt\Commons;

use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;
use Eidosmedia\Cobalt\Commons\Exceptions\SDKException;
use Eidosmedia\Cobalt\Commons\Exceptions\ServiceNotAvailableException;
use Eidosmedia\Cobalt\Commons\Request;
use GuzzleHttp\Client as GuzzleHttpClient;
use Stringy\StaticStringy as S;

class HttpClient {

    const MAX_RETRIES_FOR_SAFETY = 10;

    private $servicesInfosCache = [];
    private $sdk;

    public function __construct($sdk, $discoveryUri) {
        $this->sdk = $sdk;
        $this->httpClient = new GuzzleHttpClient();
        $this->servicesInfosCache['discovery'] = new ServiceInfo('discovery', $discoveryUri);
    }

    public function get($serviceType, $path, $queryParams = null, $headerParams = null) {
        $request = new Request($serviceType);
        $request->setPath($path);
        $request->setQueryParams($queryParams);
        $request->setHeaderParams($headerParams);
        return $this->doRequest($request);
    }

    public function post($serviceType, $path, $queryParams = null, $headerParams = null, $body = null) {
        $request = new Request($serviceType, Request::HTTP_METHOD_POST);
        $request->setPath($path);
        $request->setQueryParams($queryParams);
        $request->setHeaderParams($headerParams);
        $request->setBody($body);
        return $this->doRequest($request);
    }

    private function doRequest($request) {
        $retries = 0;
        do {
            try {
                // make the call, if success return the result
                $url = $this->buildUrl($request);
                $options = $this->buildOptions($request);
                $response = $this->httpClient->request($request->getHttpMethod(), $url, $options);
                return json_decode($response->getBody(), true);
            } catch (\Exception $ex) {
                // handle exception
                if ($ex instanceof \GuzzleHttp\Exception\ServerException || 
                    $ex instanceof \GuzzleHttp\Exception\ClientException) {
                    // bad response exception, boxing it inside an HttpClientException
                    $response = $ex->getResponse();
                    throw new HttpClientException($ex, 
                        $response->getStatusCode(), 
                        $response->getReasonPhrase(), 
                        $response->getBody());
                } else if ($ex instanceof ServiceNotAvailableException ||
                    $ex instanceof \GuzzleHttp\Exception\TransferException) {
                    // check if it's retriable
                    if (!$request->isRetriable()) {
                        // the method is not retriable
                        throw new ServiceNotAvailableException('HTTP call is not retryable.', $request);
                    } else if ($retries >= $request->getMaxRetries()) {
                        // we already done the max num of retries
                        throw new ServiceNotAvailableException('HTTP call reached the maximum number of retries.', $request);
                    } else {
                        // hanlded exception, can do a retry after a sleep
                        usleep($request->getRetriesDelay());
                    }
                } else {
                    // unhandle exception, throw a generic exception
                    throw new SDKException($ex);
                }
            }
            $retries++;
        } while ($retries < HttpClient::MAX_RETRIES_FOR_SAFETY);
        throw new ServiceNotAvailableException('Unexpected service error.', $request);
    }

    private function buildUrl($request) {
        // get service uri base on the request serviceType
        // check if there is an already resolved uri for the given type
        $serviceInfo = null;
        if (isset($this->servicesInfosCache[$request->getServiceType()])) {
            $serviceInfo = $this->servicesInfosCache[$request->getServiceType()];
        }
        if ($serviceInfo != null) {
            // can use this service info
        } else {
            // get service uri from discovery service
            $serviceInfo = $this->sdk->getDiscoveryService()->getServiceInfo($request->getServiceType(), $request->getDomain(), $request->getZone());
            if ($serviceInfo == null) {
                // service not available
                throw new ServiceNotAvailableException('Service is not available.', $request);
            }
            // add service info to cache (we don't need to remove the discovery since we registered it manually)
            if ('discovery' != strtolower($request->getServiceType())) {
                $this->servicesInfosCache[$request->getServiceType()] = $serviceInfo;
            }
        }

        if (S::endsWith($serviceInfo->getUri(), '/')) {
            if (S::startsWith($request->getPath(), '/')) {
                return S::slice($serviceInfo->getUri(), 0, -1) . $request->getPath();
            } else {
                return $serviceInfo->getUri() . $request->getPath();
            }
        } else {
            if (S::startsWith($request->getPath(), '/')) {
                return $serviceInfo->getUri() . $request->getPath();
            } else {
                return $serviceInfo->getUri() . '/' . $request->getPath();
            }
        }
    }

    private function buildOptions($request) {
        $options = [];
        $queryParams = $request->getQueryParams();
        if ($queryParams != null) {
            $queryParamsStr = [];
            foreach ($queryParams as $key => $value) {
                if (isset($value)) {
                    if (gettype($value) == 'array') {
                        $valueCount = count($value);
                        if ($valueCount == 1) {
                            $queryParamsStr[] = $key . '=' . $value[0];
                        } else {
                            for ($i = 0; $i < $valueCount; $i++) {
                                $queryParamsStr[] = $key . '=' . $value[$i];
                            }
                        }
                    } else {
                        $queryParamsStr[] = $key . '=' . $value;
                    }
                }
            }
            $options['query'] = implode('&', $queryParamsStr);
        }

        $headerParams = $request->getHeaderParams();
        if ($headerParams != null) {
            $options['headers'] = $headerParams;
        }

        $tenant = $this->sdk->getTenant();
        if ($tenant != null && !empty($tenant)) {
            $options['headers']['X-Cobalt-Tenant'] = $this->sdk->getTenant();
        }

        $realm = $this->sdk->getRealm();
        if ($realm != null && !empty($realm)) {
            $options['headers']['X-Cobalt-Realm'] = $this->sdk->getRealm();
        }

        if ($request->getHttpMethod() == Request::HTTP_METHOD_POST) {
            $options['headers']['Content-Type'] = 'application/json';
        }

        if ($this->sdk->getAuthContext()->getCurrAuth() != null) {
            $emauth = $this->sdk->getAuthContext()->getCurrAuth()->getSession()->getId();
            $options['headers']['emauth'] = $emauth;
        }

        $body = $request->getBody();
        if ($body != null) {
            $options['body'] = $body;
        }

        // handle other options if needed
        return $options;
    }

}