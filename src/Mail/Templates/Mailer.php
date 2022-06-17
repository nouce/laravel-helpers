<?php

namespace Nouce\LaravelHelpers\Mail\Templates;

use Illuminate\Support\Facades\Blade;
use Nouce\LaravelHelpers\Mail\Traits\Mailable;

class Mailer {
    use Mailable;
    public $template = 'nouce-default';
    public $title;
    public $subject = 'Boxstock mail';
    public $receiver;
    public $data;
    public $translationData = [];
    public $locale = null;

    protected function setReceiver($data)
    {
        if(!isset($data['email']))
        {
            $data['email'] = config('mail.from.address');
        }

        $this->receiver = (Object) $data;
    }

    protected function getTranslationData($slug)
    {

        if(!$this->locale)
        {
            $this->locale = isset($this->data->user->id) ? $this->data->user->country->getLanguage() : 'default';
        }

        if($data = Cms::emailTranslatableData($slug, $this->locale == 'en' ? 'default' : $this->locale))
        {
            if(!$this->title)
            {
                $this->title = $data['mail_title'];
            }

            foreach($data['email_blocks'] as $block)
            {
                $this->translationData[$block['type']] = $block;
            }
        }
    }

    protected function parseCmsText($string)
    {
        $matches = [];
        preg_match_all('#\{(.*?)\}#', $string, $matches);

        foreach($matches[0] as $match)
        {
            $parsed = str_replace('{', '', $match);
            $parsed = str_replace('}', '', $parsed);
            $parsed = str_replace('.', '->', $parsed);
            $parsed = str_replace(' ', '', $parsed);

            $variableName = '$data->data->' . $parsed . ';';


            $replaceValue = Blade::render('{{ ' . $variableName . ' }}', [
                'data' => $this
            ]);

            $string = str_replace($match, $replaceValue, $string);
            $string = str_replace(':break', '<br />', $string);
        }

        return $string;
    }
}
