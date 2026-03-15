<?php

namespace App\Jobs;

use App\Mail\EmailCampaign;
use App\Models\Campaign;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailsCampaign implements ShouldQueue
{
  use Queueable, SerializesModels;

  public function __construct(
    public Campaign $campaign
  ) {
    //
  }

  public function handle(): void
  {
    foreach ($this->campaign->emailList->subscribers as $subscriber) {
      SendEmailCampaignJob::dispatch($this->campaign, $subscriber);
    }
  }
}
