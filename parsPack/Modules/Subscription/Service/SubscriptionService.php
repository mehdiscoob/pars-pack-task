<?php

namespace Modules\Subscription\Service;

use App\Models\ExpiredLog;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Subscription\Emails\ExpiredEmail;

class SubscriptionService
{
    public function changeStatusSubscription($id)
    {
        $user = User::query()->find($id);
        $subscriptions = $user->subscriptions()->where('status','active')->orWhere('status',"pending")->get();
        $expiredCount=0;
        foreach ($subscriptions as $s) {
            DB::beginTransaction();
            try {
                $preStatus = $s->status;
                $service = SubscriptionFactory::create($s->app->platform_id);
                $check = $service->checkSubscriptionStatus($s->token);
                $s->status =$check->status!=null??$check->subscription;
                $s->save();
                if ($check->status=="expired"){
                    $expiredCount=$expiredCount+1;
                }
                $expired= ExpiredLog::create(['counter'=>$expiredCount]);
                if ($preStatus = "active" && $service['status'] == "expired") {
                Mail::to('admin@gmail.com')->send(new ExpiredEmail($s->id));
                }
                return json_encode(["message" => "ok", 'status' => 200]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                    $s->status = "pending";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()) + $s->app->platform->duration);
                    $s->save();
                return json_encode(["message" => $exception->getMessage(), 'status' => 500]);
            }

        }
    }

    public function checkStatusSubscriptions()
    {
        $subscriptions = Subscription::query()->where('status','active')->orWhere('status',"pending")->get();
        $expiredCount=0;
        foreach ($subscriptions as $s) {
            DB::beginTransaction();
            try {
                $preStatus = $s->status;
                $service = SubscriptionFactory::create($s->app->platform_id);
                $check = $service->checkSubscriptionStatus($s->token);
                $s->status =$check->status!=null??$check->subscription;
                $s->save();
                if ($check->status=="expired"){
                    $expiredCount=$expiredCount+1;
                }
                $expired= ExpiredLog::create(['counter'=>$expiredCount]);
                if ($preStatus == "active" && $service['status'] == "expired") {
                    Mail::to('admin@gmail.com')->send(new ExpiredEmail($s->id));
                }
                return json_encode(["message" => "ok", 'status' => 200]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                $s->status = "pending";
                $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()) + $s->app->platform->duration);
                $s->save();
                return json_encode(["message" => $exception->getMessage(), 'status' => 500]);
            }

        }
    }

    public function checkFailedStatusSubscriptions()
    {
        $subscriptions=Subscription::query()->where('subscriptions.status',"pending")
            ->whereNotNull("subscriptions.repeat_time")
            ->whereDate('repeat_time','<',now()->format('Y-m-d H:i:s'))
             ->get();
        $expiredCount=0;
        foreach ($subscriptions as $s) {
            DB::beginTransaction();
            try {
                $preStatus = $s->status;
                $service = SubscriptionFactory::create($s->app->platform_id);
                $check = $service->checkSubscriptionStatus($s->token);
                $s->status =$check->status!=null??$check->subscription;
                $s->save();
                if ($check->status=="expired"){
                    $expiredCount=$expiredCount+1;
                }
                $expired= ExpiredLog::create(['counter'=>$expiredCount]);
                if ($preStatus == "active" && $check->status == "expired") {
                    Mail::to('admin@gmail.com')->send(new ExpiredEmail($s->id));
                }
                return json_encode(["message" => "ok", 'status' => 200]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                $s->status = "pending";
                $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()) + $s->app->platform->duration);
                $s->save();
                return json_encode(["message" => $exception->getMessage(), 'status' => 500]);
            }

        }
    }

    public function getLastExpiredSubscription()
    {
        $expired=ExpiredLog::query()->orderBy('id')->first();
        return isset($expired)?$expired->counter:"notFound";
    }
}
