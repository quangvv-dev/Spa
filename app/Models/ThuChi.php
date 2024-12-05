<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThuChi extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];


    public static function search($param, $select = "*")
    {

        $data = self::select($select)->when(isset($param['category_id']) && $param['category_id'], function ($query) use ($param) {
            $query->where('danh_muc_thu_chi_id', $param['category_id']);
        })->when(isset($param['status']), function ($query) use ($param) {
            $query->where('status', $param['status']);
        })->when(isset($param['thuc_hien_id']) && $param['thuc_hien_id'], function ($query) use ($param) {
            $query->where('thuc_hien_id', $param['thuc_hien_id']);
        })->when(isset($param['arr_thuc_hien']) && $param['arr_thuc_hien'], function ($query) use ($param) {
            $query->whereIn('thuc_hien_id', $param['arr_thuc_hien']);
        })->when(isset($param['duyet_id']) && $param['duyet_id'], function ($query) use ($param) {
            $query->where('duyet_id', $param['duyet_id']);
        })->when(isset($param['id']) && $param['id'], function ($query) use ($param) {
            $query->where('id', $param['id']);
        })->when(isset($param['branch_id']) && $param['branch_id'], function ($query) use ($param) {
            $query->where('branch_id', $param['branch_id']);
        })->when(isset($param['group_branch']) && count($param['group_branch']), function ($q) use ($param) {
            $q->whereIn('branch_id', $param['group_branch']);
        })->when(isset($param['start_date']) && isset($param['end_date']), function ($query) use ($param) {
            $query->whereBetween('created_at', [
                Functions::yearMonthDay($param['start_date']) . " 00:00:00",
                Functions::yearMonthDay($param['end_date']) . " 23:59:59",
            ]);
        });

        return $data;
    }

    public function danhMucThuChi()
    {
        return $this->belongsTo(DanhMucThuChi::class);
    }

    public function lyDoThuChi()
    {
        return $this->belongsTo(LyDoThuChi::class, 'ly_do_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function duyet()
    {
        return $this->belongsTo(User::class, 'duyet_id');
    }

    public function thucHien()//người tạo đơn
    {
        return $this->belongsTo(User::class, 'thuc_hien_id');
    }

    public function lydo()//người tạo đơn
    {
        return $this->belongsTo(LyDoThuChi::class, 'ly_do_id');
    }
}
