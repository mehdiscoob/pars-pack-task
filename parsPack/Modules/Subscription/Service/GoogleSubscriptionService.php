<?php


namespace Modules\Subscription\Service;


use GuzzleHttp\Client;

class GoogleSubscriptionService
{
    public function checkSubscriptionStatus($token)
    {

        return new Client(['base_url' => "www.google.com?token=$token",
            'timeout' => 2.0,
        ]);
    }

}
