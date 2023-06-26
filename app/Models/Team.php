<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'team_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function arrayIdTeamMember()
    {
        $data = self::teamMembers()->pluck('user_id')->toArray();
        return $data;
    }

    public function getNameUser()
    {
        $data = self::arrayIdTeamMember();
        $users = User::whereIn('id', $data)->pluck('full_name')->toArray();
        return implode(', ', $users);
    }
}
