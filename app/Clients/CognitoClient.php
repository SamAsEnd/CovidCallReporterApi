<?php

namespace App\Clients;

use RuntimeException;
use GuzzleHttp\{Client, HandlerStack};

class CognitoClient
{
    public function getAccessToken(): string
    {
        $client = new Client([
            // Hook for logging
            'handler' => app(HandlerStack::class)
        ]);

        $response = $client->post(config('services.aws.cognito.endpoint'), [
            'auth' => $this->getCredentials(),
            'form_params' => ['grant_type' => 'client_credentials'],
        ]);

        if ($response->getStatusCode() !== 200) throw new RuntimeException('Failed to fetch access token from cognito.');

        $data = json_decode($response->getBody(), true);

        return $data['access_token'];
    }

    private function getCredentials()
    {
        return [
            config('services.aws.cognito.id'),
            config('services.aws.cognito.secret')
        ];
    }
}
