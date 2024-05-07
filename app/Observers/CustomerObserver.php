<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\HistoryStatus;
use App\Models\Status;
use App\User;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    /**
     * Handle the call center "created" event.
     *
     * @param App\Models\Customer $callCenter
     *
     * @return void
     */
    public function created(Customer $customer)
    {
        $customer->historyStatus()->create([
            'customer_id' => $customer->id,
            'status_id' => $customer->status_id,
            'created_at' => now(),
        ]);
        $customer->groupComments()->create([
            'customer_id' => $customer->id,
            'branch_id'   => $customer->branch_id,
            'status_id'   => $customer->status_id,
            'user_id'     => Auth::user()->id,
            'messages'    => "<span class='bold text-azure'>Tạo mới KH: </span> " . Auth::user()->full_name . " thao tác lúc " . date('H:i d-m-Y'),
        ]);
    }

    public function updated(Customer $customer)
    {
        $changedAttributes = $customer->getDirty();
        $oldData = $customer->getOriginal();
        // Kiểm tra sự thay đổi của các trường khác
        if (count($changedAttributes)) {
            $text = '';
            if (!empty(@$changedAttributes['mkt_id']) && !empty(@$oldData['mkt_id'])) {
                $text = $text.' <span class="text-purple">MKT: ' . User::find($oldData['mkt_id'])->full_name . ' --> ' . User::find($changedAttributes['mkt_id'])->full_name.'</span>';
                }
            if (!empty(@$changedAttributes['telesales_id']) && !empty(@$oldData['telesales_id'])) {
                $text = $text.' <span class="text-info">| Sale: ' . User::find($oldData['telesales_id'])->full_name . ' --> ' . User::find($changedAttributes['telesales_id'])->full_name.'</span>';
                }
            if (!empty(@$changedAttributes['status_id']) && !empty(@$oldData['status_id'])) {
                $text = $text.' <span class="text-green">| Trạng thái: ' . Status::find($oldData['status_id'])->name . ' --> ' . Status::find($changedAttributes['status_id'])->name.'</span>';
                $oldStatus = HistoryStatus::where('status_id', $changedAttributes['status_id'])->first();
                if (!empty($oldStatus)) {
                    $oldStatus->updated_at = now();
                    $oldStatus->save();
                }else{
                    $customer->historyStatus()->create([
                        'customer_id' => $customer->id,
                        'status_id' => $customer->status_id,
                        'created_at' => now(),
                    ]);
                }
            }
            if (!empty($text)){
                $customer->groupComments()->create([
                    'customer_id' => $customer->id,
                    'branch_id'   => $customer->branch_id,
                    'status_id'   => $customer->status_id,
                    'user_id'     => Auth::user()->id,
                    'messages'    => "<span class='bold text-danger'>Chỉnh sửa thông tin: </span> " .$text,
                ]);
            }
        }
    }
}
