<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiredSubscribtion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::has('subscribtions')->with('subscribtions')->get();
        foreach ($users as $user) {
            foreach ($user->subscribtions as $subscribtion) {
                $end_date = $subscribtion->end_date;
                if ($end_date < now()) {
                    $subscribtion->delete();
                }
            }
        }
    }
}
