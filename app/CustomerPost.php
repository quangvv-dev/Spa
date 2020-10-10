<?php

namespace App;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;


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
            $data = $data->when(isset($input['post']) && $input['post'], function ($query) use ($input) {
                $query->where('post_id', $input['post']);
            })->when(isset($input['telesales_id']) && $input['telesales_id'], function ($query) use ($input) {
                $query->where('telesales_id', $input['telesales_id']);
            })->when(isset($input['status']), function ($query) use ($input) {
                $query->where('status', $input['status']);
            })->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                });
//            ->when(isset($input['campaign_id']) && $input['campaign_id'], function ($query) use ($input) {
//                $post = Post::where('campaign_id', $input['campaign_id'])->pluck('id')->toArray();
//                $query->whereIn('post_id', $post);
//            })
        }

        return $data;
    }

    public function telesales()
    {
        return $this->belongsTo(User::class, 'telesales_id');

    }

    public function setGroupAttribute($group)
    {
        $this->attributes['group'] = json_encode($group);
    }

    public function getGroupAttribute($group)
    {
        return json_decode($group);
    }
}
