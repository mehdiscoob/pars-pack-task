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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function changeStatusSubscription($id)
    {
        return $this->subscriptionService->changeStatusSubscription($id);
    }


}
