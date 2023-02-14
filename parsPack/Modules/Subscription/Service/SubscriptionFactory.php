<?php

namespace Modules\Subscription\Service;

class SubscriptionFactory
{
    public static function create($id)
    {
        if ($id == 1) {
            return new GoogleSubscriptionService();

        }
        return new AppleSubscriptionService();
    }
}
