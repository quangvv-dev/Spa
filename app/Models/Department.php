<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id', 'id');
    }

    public function child()
    {
        return Department::where('parent_id', $this->id)->get();
    }

    public function childRelation()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function position()
    {
        return $this->hasMany(Position::class);
    }
}
