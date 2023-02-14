<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Subscription\Emails\ExpiredEmail;
use Modules\Subscription\Service\AppleSubscriptionService;
use Modules\Subscription\Service\GoogleSubscriptionService;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $subscriptions = Subscription::query()->where('status','active')->orWhere('status',"pending")->get();
        foreach ($subscriptions as $s) {
            DB::beginTransaction();
            try {
                $preStatus = $s->status;
                if ($s->app->platform_id == 1) {
                    $service = new GoogleSubscriptionService();
                    $check = $service->checkSubscriptionStatus($s->token);
                    $s->status = $check->status;
                    $s->save();
                } elseif ($s->app->platform_id == 2) {
                    $service = new AppleSubscriptionService();
                    $check = $service->checkSubscriptionStatus($s->token);
                    $s->status = $check->subscription;
                    $s->save();
                }
                if ($preStatus = "active" && $s->status == "expired") {
                    Mail::to('admin@gmail.com')->send(new ExpiredEmail($s->id));
                }
                return json_encode(["message" => "ok", 'status' => 200]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                if ($s->app->platform_id == 1) {
                    $s->status = "pending";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()) + 3600);
                    $s->save();
                } elseif ($s->app->platform_id == 2) {
                    $s->status = "pending";
                    $s->reapet_time = date("Y-m-d H:i:s", strtotime(now()) + 7200);
                    $s->save();
                }
                return json_encode(["message" => $exception->getMessage(), 'status' => 500]);
            }

        }
    }
}
