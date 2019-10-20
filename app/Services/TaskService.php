<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Components\Filesystem\Filesystem;
use App\Helpers\Functions;
use App\Models\Task;

class TaskService
{
    public $task;
    private $fileUpload;

    public function __construct(Filesystem $fileUpload, Task $task)
    {
        $this->task = $task;
        $this->fileUpload = $fileUpload;
    }

    public function find($id)
    {
        $task = $this->task->where('id', $id)->first();

        return $task;
    }

    public function create(array $data)
    {
        if (empty($data)) return false;

        $handleData = $this->data($data);

        $task = $this->task->fill($handleData);

        $task->save();

        return $task;


    }

    public function data(array $data)
    {
        $data['date_from'] = isset($data['date_from']) ? Functions::yearMonthDay($data['date_from']): '';
        $data['date_to'] = isset($data['date_to']) ? Functions::yearMonthDay($data['date_to']): '';

        if (!empty($input['file_document'])) {
            $data['document'] = $this->fileUpload->uploadDocumentFile($data['file_document']);
        }

        return $data;

    }

    public function update($input, $id)
    {
        $data = $this->data($input);

        $customer = $this->find($id);

        $customer->update($data);

        return $customer;

    }
}
