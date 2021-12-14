<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThuChi extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function search($param)
    {
        $data = self::when(isset($param['category_id']) && $param['category_id'], function ($query) use ($param) {
            $query->where('danh_muc_thu_chi_id', $param['category_id']);
        })->when(isset($param['status']), function ($query) use ($param) {
            $query->where('status', $param['status']);
        })->when(isset($param['thuc_hien_id']) && $param['thuc_hien_id'], function ($query) use ($param) {
            $query->where('thuc_hien_id', $param['thuc_hien_id']);
        })->when(isset($param['duyet_id']) && $param['duyet_id'], function ($query) use ($param) {
            $query->where('duyet_id', $param['duyet_id']);
        })->when(isset($param['id']) && $param['id'], function ($query) use ($param) {
            $query->where('id', $param['id']);
        })->when(isset($param['branch_id']) && $param['branch_id'], function ($query) use ($param) {
            $query->where('branch_id', $param['branch_id']);
        });

        return $data;
    }

    public function danhMucThuChi()
    {
        return $this->belongsTo(DanhMucThuChi::class);
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
}
