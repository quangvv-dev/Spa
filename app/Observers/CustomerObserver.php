<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    /**
     * Handle the call center "created" event.
     *
     * @param App\Models\Customer $callCenter
     * @return void
     */
    public function created(Customer $customer)
    {
        $customer->groupComments()->create([
            'customer_id' => $customer->id,
            'branch_id' => $customer->branch_id,
            'status_id' => $customer->status_id,
            'user_id' => Auth::user()->id,
            'messages' => "<span class='bold text-azure'>Tạo mới KH: </span> " . Auth::user()->full_name . " thao tác lúc " . date('H:i d-m-Y'),
        ]);
    }

    public function updated(Customer $customer)
    {
//        $changedAttributes = $customer->getDirty();
//        // Loại bỏ trường 'updated_at' khỏi mảng sự thay đổi
//        unset($changedAttributes['updated_at'], $changedAttributes['is_gioithieu']);
//        // Kiểm tra sự thay đổi của các trường khác
//        if (count($changedAttributes)) {
//            $customer->groupComments()->create([
//                'customer_id' => $customer->id,
//                'branch_id' => $customer->branch_id,
//                'status_id' => $customer->status_id,
//                'user_id' => 0,
//                'messages' => "<span class='bold text-danger'>CHỈNH SỬA KH: </span> " . Auth::user()->full_name . " thao tác lúc " . date('H:i d-m-Y'),
//            ]);
//        }
    }
}
