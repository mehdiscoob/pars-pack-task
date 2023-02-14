<?php


namespace Modules\Subscription\Service;


use GuzzleHttp\Client;

class AppleSubscriptionService
{
    public function checkSubscriptionStatus($token)
    {

        return new Client(['base_url' => "www.apple.com?token=$token",
            'timeout' => 2.0,
        ]);
    }
}
