<?php

namespace Modules\Subscription\Service;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function changeStatusSubscription($id)
    {
        $user = User::query()->find($id);
        $subscriptions = $user->subscriptions()->get();
        foreach ($subscriptions as $s) {
            DB::beginTransaction();
            try {
                if ($s->app->platform_id == 1) {
                    $service = "new Service";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()));
                    $s->status = $service->status;
                    $s->save();
                }elseif ($s->app->platform_id == 2) {
                    $service = "new Service";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()));
                    $s->status = $service->subscription;
                    $s->save();
                }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                if ($s->app->platform_id == 1) {
                    $s->status = "pending";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now())+3600);
                    $s->save();
                }elseif ($s->app->platform_id == 2) {
                    $s->status = "pending";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now())+7200);
                    $s->save();
                }
            }

        }
    }
}
