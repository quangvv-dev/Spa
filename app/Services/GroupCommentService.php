<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Models\GroupComment;

class GroupCommentService
{
    public $groupComment;

    /**
     * GroupCommentService constructor.
     * @param GroupComment $groupComment
     */
    public function __construct(GroupComment $groupComment)
    {
        $this->groupComment = $groupComment;
    }

    public function find($id)
    {
        return $this->groupComment->where('id', $id)->first();
    }

    public function update($data, $id)
    {
        $model = $this->find($id);
        if (empty($data) && empty($model)) return false;

        $model->update([
            'messages' => $data['messages']
        ]);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
