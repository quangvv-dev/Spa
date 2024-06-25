<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebase = $firebaseService;

    }

    public function created(Order $order)
    {
        $order->customer->groupComments()->create([
            'customer_id' => $order->member_id,
            'branch_id'   => $order->branch_id,
            'status_id'   => $order->customer->status_id,
            'user_id'     => Auth::user()->id,
            'messages'    => "<span class='bold text-blue'>Tạo mới đơn hàng mới: </span> Phát sinh đơn hàng trị giá " .number_format($order->all_total).'đ',
        ]);
    }

    /**
     * Handle the call center "created" event.
     *
     * @param App\Models\Order $order
     *
     * @return void
     */
    public function updated(Order $order)
    {
        $changedAttributes = $order->getDirty();
        $oldData = $order->getOriginal();
        if (count($changedAttributes)) {
            $text = '';
            if (!empty($changedAttributes['all_total'])) {
                $text = $text.' <span class="text-purple">Giá trị đơn : ' .
                    number_format($oldData['all_total']) . 'đ --> ' . number_format($changedAttributes['all_total']).'đ</span>';
            }
            if (!empty($changedAttributes['created_at'])){
                $text = $text.' <span class="text-pink"> | Ngày tạo đơn : ' .
                       $oldData['created_at'] . ' --> ' . $changedAttributes['created_at'].'</span>';
            }
            if (!empty($text)){
                $order->customer->groupComments()->create([
                    'customer_id' => $order->member_id,
                    'branch_id'   => $order->branch_id,
                    'status_id'   => $order->customer->status_id,
                    'user_id'     => Auth::user()->id,
                    'messages'    => "<span class='bold text-blue'>Chỉnh sửa đơn hàng: </span> " .$text,
                ]);
            }
        }
    }
}
