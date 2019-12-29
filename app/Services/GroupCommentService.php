<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Models\GroupComment;
use App\Components\Filesystem\Filesystem;

class GroupCommentService
{
    public $groupComment;
    private $fileSystem;

    /**
     * GroupCommentService constructor.
     * @param GroupComment $groupComment
     * @param Filesystem $fileSystem
     */
    public function __construct(GroupComment $groupComment, Filesystem $fileSystem)
    {
        $this->groupComment = $groupComment;
        $this->fileSystem = $fileSystem;
    }

    public function find($id)
    {
        return $this->groupComment->where('id', $id)->first();
    }

    public function update($data, $id)
    {
        $model = $this->find($id);

        if (empty($data) && empty($model)) return false;

        $input = $this->data($data);

        $model->update($input);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }

    public function create($data)
    {
        $input = $this->data($data);

        $groupComment = $this->groupComment->fill($input);
        $groupComment->save();

        return $groupComment;
    }

    public function data($data)
    {
        if (!empty($data['image'])) {
            $data['image'] = $this->fileSystem->uploadCommentImage($data['image']);
        }

        return $data;
    }
}
