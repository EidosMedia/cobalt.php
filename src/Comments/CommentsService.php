<?php

namespace Eidosmedia\Cobalt\Comments;

use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Comments\Entities\Post;
use Eidosmedia\Cobalt\Comments\Entities\PaginatedComments;

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
        $query = [
            'id' => $postOptions->getThreadId(),
            'externalObjectId' => $postOptions->getExternalObjectId(),
            'rootId' => $postOptions->getRootId(),
            'parentId' => $postOptions->getParentId(),
            'statusId' => $postOptions->getStatusId(),
            'offset' => $postOptions->getOffset(),
            'limit' => $postOptions->getLimit(),
            'postId' => $postOptions->getPostId(),
            'lastPostId' => $postOptions->getLastPostId(),
            'utag' => $postOptions->getUtag(),
            'utagFilter' => $postOptions->getUtagFilter(),
            'sort' => $postOptions->getSort()
        ];
        $response = $this->getHttpClient()->get(self::SERVICE_TYPE, '/threads/posts', $query);
        $posts = [];
        foreach ($response['result'] as $post) {
            $posts[] = new Post($post);
        }
        return new PaginatedComments($posts, $response['utag']);
    }

    public function createPost($post) {
        if ($post instanceof Post) {
            $post = $post->getPost();
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/create', null, null, $body);
        return new Post($response);
    }

    public function updatePost($post) {
        if ($post instanceof Post) {
            $post = $post->getPost();
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/update', null, null, $body);
        return new Post($response);
    }

    public function deletePost($post) {
        if ($post instanceof Post) {
            $post = $post->getPost();
        }
        $body = json_encode($post);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/posts/delete', null, null, $body);
        return new Post($response);
    }

}