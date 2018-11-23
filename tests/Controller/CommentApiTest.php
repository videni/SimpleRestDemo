<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class CommentApiTest extends JsonApiTestCase
{
    use CommandRunnerTrait, JwtTokenTrait;

    /**
     * @test
     */
    public function it_allows_to_create_comment()
    {
        $fixtures = $this->loadFixturesFromFiles([
            'resources/post.yml'
        ]);

        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $publishedAt = (new \DateTime('+1 day'))->format('Y-m-d H:i:s');

        $data =
        <<<EOT
        {
            "content": "What a wonderfull post!",
            "published_at": "{$publishedAt}"
        }
EOT;

        $this->client->request(
            'POST',
            sprintf('/api/admin/posts/%s/comments', $fixtures['post1']->getId()),
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ],
            $data
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'comment/create_comment_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_allows_to_view_comment()
    {
        $fixtures = $this->loadFixturesFromFiles([
            'resources/post.yml',
            'resources/comment.yml',
        ]);

        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $this->client->request(
            'GET',
            sprintf('/api/admin/comments/%s', $fixtures['comment1']->getId()),
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ]
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'comment/view_comment_response', Response::HTTP_OK);
    }

     /**
     * @test
     */
    public function it_allows_to_update_comment()
    {
        $fixtures = $this->loadFixturesFromFiles([
            'resources/post.yml',
            'resources/comment.yml',
        ]);

        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $publishedAt = (new \DateTime('+1 day'))->format('Y-m-d H:i:s');

        $data =
        <<<EOT
        {
            "content": "What a wonderfull post!",
            "published_at": "{$publishedAt}"
        }
EOT;

        $this->client->request(
            'PUT',
            sprintf('/api/admin/comments/%s', $fixtures['comment1']->getId()),
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ],
            $data
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'comment/update_comment_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_to_delete_comment()
    {
        $fixtures = $this->loadFixturesFromFiles([
            'resources/post.yml',
            'resources/comment.yml',
        ]);

        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $this->client->request(
            'DELETE',
            sprintf('/api/admin/comments/%s', $fixtures['comment1']->getId()),
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ]
        );

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

     /**
     * @test
     */
    public function it_allows_to_get_comments()
    {
        $fixtures = $this->loadFixturesFromFiles([
            'resources/post.yml',
            'resources/comment.yml',
        ]);

        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $this->client->request(
            'GET',
            sprintf('/api/admin/posts/%s/comments', $fixtures['post1']->getId()),
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ]
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'comment/get_comments_response', Response::HTTP_OK);
    }
}
