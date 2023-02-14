<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Subscription\Service\GoogleSubscriptionService;

class CheckStatusGoogleSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-status-google-subscription';

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
        $subscriptions=Subscription::query()->where('subscriptions.status',"pending")
            ->join('apps','subscriptions.app_id','=','apps.id')
            ->whereNotNull("subscriptions.repeat_time")
            ->where('apps.platform_id','1')->get();
        foreach ($subscriptions as $s){
            DB::beginTransaction();
            try {
                $service = new GoogleSubscriptionService();
                $check=$service->checkSubscriptionStatus($s->token);
                $s->status = $check->status;
                $s->save();
                return json_encode(["message"=>"ok",'status'=>200]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                $s->status = "pending";
                $s->reapet_time = date("Y-m-d H:i:s", strtotime(now())+3600);
                $s->save();
                return json_encode(["message"=>$exception->getMessage(),'status'=>500]);
            }
        }
    }
}
