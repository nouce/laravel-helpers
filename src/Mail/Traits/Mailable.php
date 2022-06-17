<?php

namespace Nouce\LaravelHelpers\Mail\Traits;

use Illuminate\Support\Facades\Blade;
use Nouce\LaravelHelpers\Mail\SendInBlue\SendInBlue;

trait Mailable {
    protected function getHtml()
    {
        return view('partials.mail.mail', [
            'partials' => $this->partials()
        ])->render();
    }

    public function render()
    {
        return $this->getHtml();
    }

    public function send()
    {
        return SendInBlue::api()->templates($this->template)->send(
            [
                'name' => config('mail.from.name'),
                'email' =>  config('mail.from.address')
            ],
            [['email' => $this->receiver->email]],
            [
                'name' => config('mail.from.name'),
                'email' =>  config('mail.from.address')
            ],
            [],
            [
                'main_title' => $this->title,
                'subject' => $this->subject,
                'email_body' => $this->getHtml()
            ]
        );
    }
}
