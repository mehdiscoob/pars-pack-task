<?php

namespace Modules\Subscription\Service;

use App\Models\User;

class SubscriptionService
{
    public function changeStatusSubscription($id)
    {
        $user = User::query()->find($id);
        $subscriptions=$user->subscriptions()->get();
        foreach ($subscriptions as $s){

        }
    }
}
