<?php

namespace Eidosmedia\Cobalt\Comments;

use Eidosmedia\Cobalt\Comments\Entities\PaginatedComments;
use Eidosmedia\Cobalt\Comments\Entities\Post;
use Eidosmedia\Cobalt\Comments\Entities\PostOptions;
use Eidosmedia\Cobalt\Commons\Service;

/**
 * Comments service
 * 
 * @example
 * // get Comments service from Cobalt SDK <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $sdk = new CobaltSDK($discoveryUri); <br />
 * <br/>
 * // get Comments Service instance <br />
 * $commentsService = $sdk->getCommentsService(); <br />
 */
class CommentsService extends Service {

    const SERVICE_TYPE = 'comments';

    public function __construct($sdk) {
        parent::__construct($sdk);
    }

    public function listPosts($postOptions) {
        if ($postOptions instanceof PostOptions) {
            $postOptions = PostOptions::toAssociativeArray($postOptions);
        }

        $query = $postOptions;

        $response = $this->getHttpClient()->get(self::SERVICE_TYPE, '/threads/posts', $query);
        $posts = [];
        foreach ($response['result'] as $post) {
            $posts[] = new Post($post);
        }
        return new PaginatedComments($posts, $response['utag']);
    }

    public function createPost($post) {
        if ($post instanceof Post) {
            $post = Post::toAssociativeArray($post);
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/create', null, null, $body);
        return new Post($response);
    }

    public function updatePost($post) {
        if ($post instanceof Post) {
            $post = Post::toAssociativeArray($post);
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/update', null, null, $body);
        return new Post($response);
    }

    public function deletePost($post) {
        if ($post instanceof Post) {
            $post = Post::toAssociativeArray($post);
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/delete', null, null, $body);
        return new Post($response);
    }

}