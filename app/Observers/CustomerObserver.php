<?php

namespace App\Observers;

use App\Models\Customer;
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
        // Loại bỏ trường 'updated_at' khỏi mảng sự thay đổi
        unset($changedAttributes['updated_at'], $changedAttributes['is_gioithieu']);
        // Kiểm tra sự thay đổi của các trường khác
        if (count($changedAttributes)) {
            $text = '';
            foreach ($changedAttributes as $k => $item) {
                if ($k == 'mkt_id') {
                    $text = $text.' <span class="text-purple">MKT: ' . User::find($oldData[$k])->full_name . ' --> ' . User::find($item)->full_name.'</span>';
                }
                if ($k == 'telesales_id') {
                    $text = $text.' <span class="text-info">| Sale: ' . User::find($oldData[$k])->full_name . ' --> ' . User::find($item)->full_name.'</span>';
                }
                if ($k == 'status_id') {
                    $text = $text.' <span class="text-green">| Trạng thái: ' . Status::find($oldData[$k])->name . ' --> ' . Status::find($item)->name.'</span>';
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
