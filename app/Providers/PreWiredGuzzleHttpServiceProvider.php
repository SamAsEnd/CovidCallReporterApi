<?php

namespace App\Providers;

use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

use Psr\Http\Message\ResponseInterface;
use App\Clients\{ApiGatewayClient, CognitoClient};
use GuzzleHttp\{Client, HandlerStack, MessageFormatter, Middleware as GuzzleMiddleware};

class PreWiredGuzzleHttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        // Hook for logging
        $this->app->singleton(HandlerStack::class, function () {
            $stack = HandlerStack::create();

            // log
            $stack->push(GuzzleMiddleware::log(
                app(Logger::class),
                new MessageFormatter(MessageFormatter::DEBUG)
            ), 'logger');

            // rewind
            $stack->after('logger', GuzzleMiddleware::mapResponse(function (ResponseInterface $response) {
                $body = $response->getBody();

                if ($body->isSeekable()) $body->rewind();

                return $response;
            }));

            return $stack;
        });

        $this->app->singleton(Client::class, function () {
            $token = app(CognitoClient::class)->getAccessToken();

            return app(ApiGatewayClient::class)->getClient($token);
        });
    }

    public function provides()
    {
        return [
            HandlerStack::class,
            Client::class,
        ];
    }
}
