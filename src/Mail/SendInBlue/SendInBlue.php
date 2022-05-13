<?php

namespace Nouce\LaravelHelpers\Mail\SendInBlue;

class SendInBlue {
    public static function api() {
        return new Endpoints();
    }
}
