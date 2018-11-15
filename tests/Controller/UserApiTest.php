<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class UserApiTest extends JsonApiTestCase
{
   use JwtTokenTrait, CommandRunnerTrait;

    /**
     * @test
     */
    public function it_allows_to_get_users()
    {
        $this->client->setServerParameter('HTTP_Authorization', $this->getToken("jane_admin", "kitten"));

        $this->client->request('GET', '/api/admin/users', [], [], [ 'HTTP_ACCEPT' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'user/get_users_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_denies_an_user_creation_for_not_authenticated_users()
    {
        $this->client->request('POST', '/api/admin/users');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }
}
