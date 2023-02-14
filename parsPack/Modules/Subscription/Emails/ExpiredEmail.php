<?php

namespace Modules\Subscription\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpiredEmail extends Mailable
{
    private $subId;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subId)
    {
        $this->subId=$subId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sub_id=$this->subId;
        return $this->view('subscription::expired-email',compact('sub_id'));
    }
}
