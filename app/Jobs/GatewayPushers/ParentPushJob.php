<?php

namespace App\Jobs\GatewayPushers;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class ParentPushJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(Client $client)
    {
        $client->request($this->method(), $this->endPoint(), [
            'json' => $this->data
        ]);
    }

    protected function method(): string
    {
        return 'POST';
    }

    protected abstract function endPoint(): string;
}
