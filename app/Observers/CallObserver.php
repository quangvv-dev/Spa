<?php

namespace App\Observers;

use App\Models\CallCenter;

class CallObserver
{
    /**
     * Handle the call center "created" event.
     *
     * @param App\Models\CallCenter $callCenter
     * @return void
     */
    public function created(CallCenter $callCenter)
    {
        if ($callCenter->call_status == 'ANSWERED') {
            $callCenter->customer->groupComments()->create([
                'user_id' => @$callCenter->user->id ?? 0,
                'branch_id' => @$callCenter->customer->branch_id ?? 0,
                'status_id' => @$callCenter->customer->status_id ?? 0,
                'call_id' => @$callCenter->id,
            ]);
        }
    }
}
