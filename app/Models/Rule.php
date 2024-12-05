<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['title', 'start_at', 'end_at', 'status', 'configs'];

    public function ruleOutput()
    {
        return $this->hasMany(RuleOutput::class, 'rule_id');
    }
}
