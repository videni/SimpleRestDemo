<?php

namespace App\Tests\Controller;

trait JwtTokenTrait
{
    public function getToken($username, $password)
    {
        $data =
<<<EOT
        {
            "username": "{$username}",
            "password": "{$password}"
        }
EOT;
        $this->client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json', 'ACCEPT' => 'application/json'], $data);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        return sprintf('Bearer %s', $response['token']);
    }
}
