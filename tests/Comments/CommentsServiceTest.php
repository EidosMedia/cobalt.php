<?php

namespace Eidosmedia\Tests\Cobalt\Comments;

use Eidosmedia\Cobalt\CobaltSDK;
use Eidosmedia\Cobalt\Comments\CommentsService;
use Eidosmedia\Cobalt\Comments\Entities\PaginatedComments;
use Eidosmedia\Cobalt\Comments\Entities\Post;
use Eidosmedia\Cobalt\Comments\Entities\PostOptions;
use PHPUnit\Framework\TestCase;

class CommentsServiceTest extends TestCase {

    private static $discoveryUri = 'http://localhost:8480/discovery';
    private static $siteName = 'test-site';
    private static $sdk;
    private static $directoryService;
    private static $commentsService;
    private static $externalObjectId;

    public static function setUpBeforeClass() {
        self::$sdk = new CobaltSDK(self::$discoveryUri);
        self::$directoryService = self::$sdk->getDirectoryService();
        self::$directoryService->login('admin', 'admin');
        self::$commentsService = self::$sdk->getCommentService();
        self::$externalObjectId = self::$sdk->getSiteService(self::$siteName)->getSitemap()->getRoot()->getId();
        self::assertInstanceOf(CommentsService::class, self::$commentsService);
    }

    public static function tearDownAfterClass() {
        self::$directoryService->logout();
    }

    public function testCreatePost() {
        $domainExternalObjectId = self::$externalObjectId;
        $forumExternalObjectId = self::$externalObjectId;
        $externalObjectId = self::$externalObjectId;
        $status = 'ACTIVE';
        $rootId = '0';
        $parentId = '0';
        $content = 'posting from PHP SDK';
        $tags = ['sports', 'soccer'];
        $post = new Post();
        $post->setDomainExternalObjectId($domainExternalObjectId);
        $post->setForumExternalObjectId($forumExternalObjectId);
        $post->setExternalObjectId($externalObjectId);
        $post->setRootId($rootId);
        $post->setStatusId($status);
        $post->setParentId($parentId);
        $post->setContent($content);
        $post->setTags($tags);
        $createdPost = self::$commentsService->createPost($post);
        self::assertInstanceOf(Post::class, $createdPost);
        self::assertEquals($domainExternalObjectId, $post->getDomainExternalObjectId());
        self::assertEquals($forumExternalObjectId, $post->getForumExternalObjectId());
        self::assertEquals($externalObjectId, $post->getExternalObjectId());
        self::assertEquals($rootId, $post->getRootId());
        self::assertEquals($status, $post->getStatusId());
        self::assertEquals($parentId, $post->getParentId());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($tags, $post->getTags());
    }

    public function testListPost() {
        $postOptions = [
            'externalObjectId' => self::$externalObjectId
        ];
        $postsFound = self::$commentsService->listPosts(new PostOptions($postOptions));
        self::assertInstanceOf(PaginatedComments::class, $postsFound);
        self::assertTrue($postsFound->getResult() > 0);
        self::assertEquals(count($postsFound->getResult()), $postsFound->getCount());
        // utag is the date in unix timestamp (milliseconds) in which the request was executed
        self::assertTrue(round(microtime(true) * 1000) > $postsFound->getUtag());
    }

    public function testUpdatePost() {
        $originalPost = [
            'domainExternalObjectId' => self::$externalObjectId,
            'forumExternalObjectId' => self::$externalObjectId,
            'externalObjectId' => self::$externalObjectId,
            'rootId' => '0',
            'parentId' => '0',
            'content' => 'posting from PHP SDK',
            'tags' => ['sports', 'soccer']
        ];
        $updatedContent = 'updated comment from php sdk';
        $createdPost = self::$commentsService->createPost($originalPost);
        $createdPost->setContent($updatedContent);
        $updatedPost = self::$commentsService->updatePost($createdPost);
        self::assertInstanceOf(Post::class, $updatedPost);
        self::assertEquals($updatedContent, $updatedPost->getContent());
    }

    public function testDeletePost() {
        $originalPost = [
            'domainExternalObjectId' => self::$externalObjectId,
            'forumExternalObjectId' => self::$externalObjectId,
            'externalObjectId' => self::$externalObjectId,
            'rootId' => '0',
            'parentId' => '0',
            'content' => 'posting from PHP SDK',
            'tags' => ['sports', 'soccer']
        ];
        $createdPost = self::$commentsService->createPost($originalPost);
        $deletedPost = self::$commentsService->deletePost($createdPost);
        self::assertInstanceOf(Post::class, $deletedPost);
    }

}