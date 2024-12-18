<?php

namespace App\Models;

use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $guarded = ['id'];
    const TYPE_ORDER_DEFAULT = 0;
    const TYPE_ORDER_ADVANCE = 1;
    const TYPE_ORDER_PROCESS = 2;
    const TYPE_ORDER_GUARANTEE = 3; //guarantee
    const TYPE_ORDER_RESERVE = 4; //Reserve
    use SoftDeletes;

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'member_id', 'id')->withTrashed();
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'order_id', 'id')->orderByDesc('id');
    }

    public function historyUpdateOrders()
    {
        return $this->hasMany(HistoryUpdateOrder::class, 'order_id', 'id');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'order_id', 'id');
    }

    public function spaTherapisst()
    {
        return $this->belongsTo(User::class, 'spa_therapisst_id', 'id');
    }

    public function support()
    {
        return $this->belongsTo(User::class, 'support_id', 'id');
    }

    public function supportOrder()
    {
        return $this->hasOne(SupportOrder::class);
    }
//    public function yTaChinh(){
//        return $this->belongsTo(SupportOrder::class,'yta1_id');
//    }
//    public function yTaPhu(){
//        return $this->belongsTo(SupportOrder::class,'yta2_id');
//    }
//    public function tuVanChinh(){
//        return $this->belongsTo(SupportOrder::class,'support1_id');
//    }
//    public function tuVanPhu(){
//        return $this->belongsTo(SupportOrder::class,'support2_id');
//    }

//    public function paymentHistory()
//    {
//        return $this->hasMany(PaymentHistory::class);
//    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id')->withTrashed();
    }

    public static function search($input)
    {
        $data = self::with('orderDetails');

        if ($input) {
            $data = $data
                ->when(isset($input['group']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('group_id', $input['group']);
                    });
                })
                ->when(isset($input['telesales']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('telesales_id', $input['telesales']);
                    });
                })
                ->when(isset($input['marketing']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('mkt_id', $input['marketing']);
                    });
                })
                ->when(isset($input['service']), function ($query) use ($input) {
                    $query->whereHas('orderDetails', function ($q) use ($input) {
                        $q->where('booking_id', $input['service']);
                    });
                })
                ->when(isset($input['customer']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('full_name', 'like', '%' . $input['customer'] . '%')
                            ->orWhere('phone', 'like', '%' . $input['customer'] . '%');
                    });
                })
                ->when(isset($input['the_rest']), function ($query) use ($input) {
                    if ($input['the_rest'] == OrderConstant::THE_REST) {
                        $query->where('the_rest', '>', 0);
                    } elseif ($input['the_rest'] == OrderConstant::NONE_REST) {
                        $query->where('the_rest', 0);
                    }
                })
                ->when(isset($input['payment_type']), function ($query) use ($input) {
                    $query->whereNotNull('payment_type')->where('payment_type', $input['payment_type']);
                })
                ->when(isset($input['order_type']), function ($query) use ($input) {
                    $query->where('type', $input['order_type']);
                })
                ->when(isset($input['member_id']), function ($query) use ($input) {
                    $query->where('member_id', $input['member_id']);
                }) ->when(isset($input['cskh_id']), function ($query) use ($input) {
                    $query->where('cskh_id', $input['cskh_id']);
                })
                ->when(isset($input['role_type']), function ($query) use ($input) {
                    $query->where('role_type', $input['role_type']);
                })
                ->when(isset($input['data_time']), function ($query) use ($input) {
                    $query->when($input['data_time'] == 'TODAY' ||
                        $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                        $q->whereDate('created_at', getTime(($input['data_time'])));
                    })
                        ->when($input['data_time'] == 'THIS_WEEK' ||
                            $input['data_time'] == 'LAST_WEEK' ||
                            $input['data_time'] == 'THIS_MONTH' ||
                            $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                            $q->whereBetween('created_at', getTime(($input['data_time'])));
                        });
                })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                })
                ->when(isset($input['bor_none']), function ($query) use ($input) {
                    $query->when($input['bor_none'] == 'advanced', function ($q) use ($input) {
                        $q->where('the_rest', '>', 0);
                    })
                        ->when($input['bor_none'] == 'paid', function ($q) use ($input) {
                            $q->where('the_rest', 0);
                        });
                })
                ->when(isset($input['branch_id']), function ($query) use ($input) {
                    $query->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                })
                ->when(isset($input['order_cancel']), function ($query) use ($input) {
                    $query->onlyTrashed();
                })->orderByDesc('id');
        }

        return $data->paginate(StatusCode::PAGINATE_20);
    }

    public static function searchAll($input)
    {
        $data = self::with('orderDetails');

        if ($input) {
            $data = $data->when(isset($input['group']), function ($query) use ($input) {
                $customer = CustomerGroup::where('category_id', $input['group'])->pluck('customer_id')
                    ->toArray();
                $query->whereIn('member_id', $customer);
            })
                ->when(isset($input['telesales']), function ($query) use ($input) {
                    $query->where('telesale_id', $input['telesales']);
                })->when(isset($input['carepage_id']), function ($query) use ($input) {
                    $query->where('carepage_id', $input['carepage_id']);
                })
                ->when(isset($input['marketing']), function ($query) use ($input) {
                    $query->where('mkt_id', $input['marketing']);
                })->when(isset($input['arr_marketing']), function ($query) use ($input) {
                    $query->whereIn('mkt_id', $input['arr_marketing']);
                })
                ->when(isset($input['service']), function ($query) use ($input) {
                    $query->whereHas('orderDetails', function ($q) use ($input) {
                        $q->where('booking_id', $input['service']);
                    });
                })
                ->when(isset($input['customer']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('full_name', 'like', '%' . $input['customer'] . '%')
                            ->orWhere('phone', 'like', '%' . $input['customer'] . '%');
                    });
                })->when(isset($input['source_fb']), function ($query) use ($input) {
                    $query->whereHas('customer', function ($q) use ($input) {
                        $q->where('source_fb', $input['source_fb']);
                    });
                })->when(isset($input['gifts']), function ($query) use ($input) {
                    $arrOrders = Gift::select('order_id')->where('product_id',$input['gifts'])
                        ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                            $q->whereBetween('created_at', [
                                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                            ]);
                        })->pluck('order_id')->toArray();
                    $query->whereIn('id', $arrOrders);
                })
                ->when(isset($input['payment_type']), function ($query) use ($input) {
                    $query->whereNotNull('payment_type')->where('payment_type', $input['payment_type']);
                })
                ->when(isset($input['order_type']), function ($query) use ($input) {
                    $query->where('type', $input['order_type']);
                })
                ->when(isset($input['role_type']), function ($query) use ($input) {
                    $query->where('role_type', $input['role_type']);
                })
                ->when(isset($input['data_time']), function ($query) use ($input) {
                    $query->when($input['data_time'] == 'TODAY' ||
                        $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                        $q->whereDate('created_at', getTime(($input['data_time'])));
                    })
                        ->when($input['data_time'] == 'THIS_WEEK' ||
                            $input['data_time'] == 'LAST_WEEK' ||
                            $input['data_time'] == 'THIS_MONTH' ||
                            $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                            $q->whereBetween('created_at', getTime(($input['data_time'])));
                        });
                })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                })
                ->when(isset($input['bor_none']), function ($query) use ($input) {
                    $query->when($input['bor_none'] == 'unpaid', function ($q) use ($input) {
                        $q->where('the_rest', '<>', 0);
                    })
                        ->when($input['bor_none'] == 'paid', function ($q) use ($input) {
                            $q->where('the_rest', 0);
                        })
                        ->when($input['bor_none'] == 'payment', function ($q) use ($input) {
                            if (isset($input['start_date']) && isset($input['end_date'])) {
                                $detail = PaymentHistory::whereBetween('payment_date', [
                                    Functions::yearMonthDay($input['start_date']),
                                    Functions::yearMonthDay($input['end_date']),
                                ])->groupBy('order_id')->pluck('order_id')->toArray();
                            } else {
                                $detail = PaymentHistory::whereDate('payment_date', '=', date('Y-m-d'))
                                    ->groupBy('order_id')->pluck('order_id')->toArray();
                            }
                            $q->whereIn('id', $detail);
                        });
                })
                ->when(isset($input['branch_id']) && empty($input['phone']), function ($query) use ($input) {
                    $query->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                })
                ->when(isset($input['is_upsale']), function ($query) use ($input) {
                    $query->where('is_upsale', $input['is_upsale']);
                })->when(isset($input['support_id']), function ($query) use ($input) {
                    $history_orders = HistoryUpdateOrder::search($input)
                        ->where('user_id', $input['support_id'])->orWhere('support_id', $input['support_id'])->select('order_id')
                        ->orWhere('support2_id', $input['support_id'])->groupBy('order_id')->pluck('order_id')->toArray();
                    $query->whereIn('id', $history_orders);
                })
                ->when(isset($input['order_cancel']), function ($query) use ($input) {
                    $query->onlyTrashed();
                });
            if (isset($input['phone'])) {
                $customer = Customer::where('phone', $input['phone'])->pluck('id');

                $data = $data->whereIn('member_id', $customer);
            }
        }

        return $data;
    }

    public function getNamePaymentTypeAttribute()
    {
        if ($this->payment_type === 1) {
            return "Tiền mặt";
        } elseif ($this->payment_type === 2) {
            return "Thẻ";
        } elseif ($this->payment_type === 4) {
            return "Thẻ";
        } else {
            return "Điểm";
        }
    }

    public function getNameTypeAttribute()
    {
        if ($this->type === self::TYPE_ORDER_DEFAULT) {
            return "Đơn hàng thường";
        }

        if ($this->type === self::TYPE_ORDER_ADVANCE) {
            return "Liệu trình";
        }

    }

    public function getDiscountOnceServiceAttribute()
    {
        $discount = OrderDetail::select('number_discount')->where('order_id', $this->id)
            ->sum('number_discount');
        return $discount;
    }

    public function getServiceTextAttribute()
    {
        $raw = OrderDetail::where('order_id', $this->id)->pluck('booking_id')->toArray();
        $service = Services::whereIn('id', $raw)->withTrashed()->pluck('name')->toArray();
        return count($service) ? implode("<br>", $service) : '';
    }

    public function getServiceTextDestroyAttribute()
    {
        $raw = OrderDetail::where('order_id', $this->id)->withTrashed()->pluck('booking_id')->toArray();
        $service = Services::whereIn('id', $raw)->withTrashed()->pluck('name')->toArray();
        return count($service) ? implode("<br>", $service) : '';
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function ($order) {
            $order->orderDetails()->delete();
        });
    }

    public static function getAll($input)
    {
        $data = self::select('id', 'all_total', 'gross_revenue')->orderBy('id', 'desc');

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when(!empty($input['data_time']) && ($input['data_time'] == 'TODAY' ||
                        $input['data_time'] == 'YESTERDAY'), function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when(!empty($input['data_time']) && ($input['data_time'] == 'THIS_WEEK' ||
                            $input['data_time'] == 'LAST_WEEK' ||
                            $input['data_time'] == 'THIS_MONTH' ||
                            $input['data_time'] == 'LAST_MONTH'), function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                })
                ->when(isset($input['spa_therapisst_id']), function ($query) use ($input) {
                    $query->where('spa_therapisst_id', $input['spa_therapisst_id']);
                })->when(isset($input['support_id']), function ($query) use ($input) {
                    $query->where('support_id', $input['support_id']);
                })->when(isset($input['branch_id']), function ($query) use ($input) {
                    $query->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
        }
        $data = $data->get();
        return $data;
    }

    public static function returnRawData($input)
    {
        $data = self::select('id', 'member_id', 'all_total', 'gross_revenue', 'the_rest', 'created_at')
            ->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            })->when(isset($input['role_type']), function ($query) use ($input) {
                $query->where('role_type', $input['role_type']);
            })->when(isset($input['member_arr']), function ($query) use ($input) {
                $query->whereIn('member_id', $input['member_arr']);
            })->when(isset($input['branch_id']), function ($query) use ($input) {
                $query->where('branch_id', $input['branch_id']);
            })->when(isset($input['member_id']), function ($query) use ($input) {
                $query->where('member_id', $input['member_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            });
        return $data;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }


}
