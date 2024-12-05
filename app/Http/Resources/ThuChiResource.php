<?php

namespace App\Http\Resources;

use App\Helpers\Functions;
use Illuminate\Http\Resources\Json\JsonResource;

class ThuChiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'               => @$this->id,
            'category_name'    => @$this->danhMucThuChi->name,
            'result'           => @$this->lydo->name,
            'price'            => @$this->so_tien,
            'creator'          => @$this->thucHien->full_name,
            'censor'           => @$this->duyet->full_name,
            'type'             => @$this->type==0?'Tiền mặt':'Chuyển Khoản',
            'note'             => @$this->note,
            'status'           => @$this->status==0?"Chờ duyệt":'Đã duyệt',
            'branch'           => @$this->branch->name,
            'created_at'       => @Functions::dayMonthYear($this->created_at),
        ];
    }
}
