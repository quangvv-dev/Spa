<?php

namespace App;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class CustomerPost extends Model
{
    protected $guarded = ['id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
