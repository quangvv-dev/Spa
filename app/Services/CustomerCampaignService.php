<?php

namespace App\Services;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Models\CallCenter;
use App\Models\CustomerCampaign;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\User;
use App\Constants\DepartmentConstant;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

class CustomerCampaignService
{
    public function __construct(CustomerCampaign $customer_campaign)
    {
        $this->customer_campaign = $customer_campaign;
    }

    public function getSaleWithCustomer($campaign)
    {
        return CustomerCampaign::select('u.id', 'u.full_name',
            DB::raw('COUNT(customer_campaign.customer_id) as customers'))
            ->leftJoin('users as u', 'u.id', '=', 'customer_campaign.sale_id')
            ->where('customer_campaign.campaign_id', $campaign->id)
            ->groupBy('customer_campaign.sale_id')
            ->get();
    }

    public function getSaleOrder($campaign)
    {
        return CustomerCampaign::select('u.id', DB::raw('COUNT(o.id) as orders'),
            DB::raw('SUM(o.all_total) as all_total'),
            DB::raw('SUM(o.gross_revenue) as gross_revenue'), DB::raw('SUM(o.the_rest) as the_rest'))
            ->leftJoin('users as u', 'u.id', '=', 'customer_campaign.sale_id')
            ->leftJoin('orders as o', 'o.member_id', '=', 'customer_campaign.customer_id')
            ->where('customer_campaign.campaign_id', $campaign->id)
            ->where('o.is_upsale', OrderConstant::IS_UPSALE)
            ->whereBetween('o.created_at', [
                $campaign->start_date . " 00:00:00",
                $campaign->end_date . " 23:59:59",
            ])
            ->groupBy('customer_campaign.sale_id')
            ->get();
    }

    public function getSaleSchedules($campaign)
    {
        return CustomerCampaign::select('u.id', DB::raw('COUNT(s.id) as schedules'),
            DB::raw('COUNT(customer_campaign.id)  as customers'))
            ->leftJoin('users as u', 'u.id', '=', 'customer_campaign.sale_id')
            ->leftJoin('schedules as s', 's.user_id', '=', 'customer_campaign.customer_id')
            ->whereBetween('s.date', [
                $campaign->start_date . " 00:00:00",
                $campaign->end_date . " 23:59:59",
            ])
            ->where('customer_campaign.campaign_id', $campaign->id)
            ->groupBy('customer_campaign.sale_id')
            ->get();
    }

    public function transformData($customers, $orders, $schedules)
    {
        return $customers->transform(function ($item) use ($orders, $schedules) {
            return [
                'id'            => $item->id,
                'full_name'     => $item->full_name,
                'customers'     => @$item->customers,
                'schedules'     => @$schedules->firstWhere('id', $item->id)->schedules ?? 0,
                'orders'        => @$orders->firstWhere('id', $item->id)->orders ?? 0,
                'all_total'     => @$orders->firstWhere('id', $item->id)->all_total ?? 0,
                'gross_revenue' => @$orders->firstWhere('id', $item->id)->gross_revenue ?? 0,
                'the_rest'      => @$orders->firstWhere('id', $item->id)->the_rest ?? 0,
            ];
        });
    }


}
