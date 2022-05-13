<?php

namespace Nouce\LaravelHelpers\Mail\SendInBlue;

use SendinBlue\Client\Configuration;

class Endpoints {

    protected $config;

    public function __construct()
    {
        $this->config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.sendinblue.api_key'));
    }

    public function templates($template = null)
    {
        return new Templates($this->config, $template);
    }
}
