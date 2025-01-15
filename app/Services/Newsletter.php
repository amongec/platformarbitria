<?php

namespace App\Services;

interface Newsletter
{
    public function subscribe(string $email, string $list = null);
}

class Singnup
{
    public function perform(
        
        Newsletter $newsletter = new MailchimpNewsletter
        )
        {
       
        $newsletter->subscribe('somelist');
    }
}

(new Signup())->perform();