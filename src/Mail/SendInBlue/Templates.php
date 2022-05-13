<?php

namespace Nouce\LaravelHelpers\Mail\SendInBlue;

use Nouce\LaravelHelpers\Mail\SendInBlue\Traits\Helpers;
use Exception;
use GuzzleHttp\Client as Guzzle;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Api\TransactionalEmailsApi;

class Templates {

    use Helpers;

    private $api;
    private $template;

    public function __construct($config, $template = null)
    {
        $this->template = $this->findTemplate($template);
        $this->api = new TransactionalEmailsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Guzzle(),
            $config
        );
    }

    public function endpoints()
    {
        return $this->api;
    }

    public function list()
    {
        return $this->api->getSmtpTemplates();
    }

    public function send(
        array $sender,
        array $to,
        array $replyTo,
        array $headers = [],
        array $params,
        int $template_id = null
    )
    {
        // Check is either the template name of the template name is set
        if(!$this->template && !$template_id)
        {
            throw new Exception('Template ID must be set if there\'s no template set in the constructer of the class');
        }

        $template = $this->template ? $this->template['id'] : $template_id;

        $email = new SendSmtpEmail();

        $email['subject']       = '{{ params.subject }}';
        $email['to']            = $to;
        $email['sender']        = $sender;
        $email['replyTo']       = $replyTo;

        if(count($headers) > 0)
        {
            $email['headers'] = $headers;
        }

        $email['params']        = $params;
        $email['templateId']    = $template;

        return $this->api->sendTransacEmail($email);
    }
}
