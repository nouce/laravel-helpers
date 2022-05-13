<?php

namespace Nouce\LaravelHelpers\Mail\SendInBlue\Traits;

use App\Classes\SendInBlue\SendInBlue;


trait Helpers {
    public function findTemplate($name)
    {
        if(!$name)
        {
            return null;
        }

        $templates = SendInBlue::api()->templates()->list();
        $templateObject = null;

        foreach($templates['templates'] as $template)
        {
            if($template['name'] == $name) {
                $templateObject = $template;
                return $templateObject;
            }
        }

        return false;
    }
}
