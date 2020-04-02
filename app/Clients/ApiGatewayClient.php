<?php

namespace App\Clients;

use GuzzleHttp\{Client, HandlerStack};

class ApiGatewayClient
{
    public function getClient(string $token): Client
    {
        return new Client([
            'base_uri' => config('services.aws.api_gateway.endpoint'),

            // Hook for logging
            'handler' => app(HandlerStack::class),

            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}
