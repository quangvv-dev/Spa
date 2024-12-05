<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public static function search($input)
    {
        $data = self::orderByDesc('updated_at')
            ->when(isset($input['type']) && $input['type'], function ($query) use ($input) {
                $query->where('type', $input['type']);
            })->when(isset($input['search']) && $input['type'], function ($query) use ($input) {
                $query->where('type', $input['type']);
            });
        return $data;
    }

    public function setGroupAttribute($group)
    {
        $this->attributes['group']= json_encode($group);
    }

    public function getGroupAttribute($group)
    {
        return json_decode($group);
    }
}
