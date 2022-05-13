<?php

namespace Nouce\LaravelHelpers\Payment\Mollie\Mollie;

use Mollie\Api\MollieApiClient;

class Mollie {
    public static function api()
    {
        $client = new MollieApiClient();
        $client->setApiKey(config('app.env') == 'production' ? config('services.mollie.api_key') : config('services.mollie.test_api_key'));
        return $client;
    }
}
