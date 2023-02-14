<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscription\Service\SubscriptionService;

class SubscriptionController extends Controller
{
    private $subscriptionService;

    /**
     * @param $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }


    /**
     * Checking Subscriptions`s status By User ID
     * @param $id
     * @return SubscriptionService
     */
    public function changeStatusSubscriptionByUserId($id)
    {
        return $this->subscriptionService->changeStatusSubscription($id);
    }

    /**
     * Getting Expired Last Report That checked Subscriptions
     * @return SubscriptionService
     */
    public function getLastExpiredSubscriprions()
    {
        return $this->subscriptionService->getLastExpiredSubscription();
    }

}
