<?php

namespace App;

use App\Constants\StatusCode;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class CustomerPost extends Model
{
    protected $guarded = ['id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public static function search($input)
    {
        $data = self::orderByDesc('id');

        if (isset($input)) {
            $data = $data->when(isset($input['campaign_id']) && $input['campaign_id'], function ($query) use ($input) {
                $post = Post::where('campaign_id', $input['campaign_id'])->pluck('id')->toArray();
                $query->whereIn('post_id', $post);
            });
        }

        return $data->paginate(StatusCode::PAGINATE_20);
    }
}
