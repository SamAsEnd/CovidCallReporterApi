<?php

use GuzzleHttp\Client;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('aws:toll-free', function (Client $client) {
    $result = $client->get('gateway/toll-free');

    $this->alert($result->getStatusCode());
    dump(json_decode($result->getBody(), true));
})->describe('Display the toll-free call report data');
