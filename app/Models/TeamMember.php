<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public static function search($search)
    {
        $docs = self::when(isset($search['teamMember']) && $search['teamMember'], function ($query) use ($search) {
            return $query->where('team_id',  $search['teamMember']);
        })->when(isset($search['department_id']) && $search['department_id'], function ($query) use ($search) {
            return $query->where('department_id',  $search['department_id']);
        })->orderBy('id', 'desc');
        return $docs;
    }
}
