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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $data['task_status_id'] = 1;

        $handleData = $this->data($data);

        $task = $this->task->fill($handleData);

        $task->save();

        return $task;


    }

    public function data(array $data)
    {
        $data['date_from'] = isset($data['date_from']) ? Functions::yearMonthDay($data['date_from']): '';
        $data['date_to'] = isset($data['date_to']) ? Functions::yearMonthDay($data['date_to']): '';
        $data['taskmaster_id'] = Auth::user()->id;

        $data['code'] = $this->genderCode();

        if (!empty($data['file_document'])) {
            $data['document'] = $this->fileUpload->uploadDocumentFile($data['file_document']);
        }

        return $data;

    }

    public function genderCode()
    {
        $today = Carbon::parse(Carbon::now())->format('Y-m');

        $task = $this->task->count() +1;

        $num = '';

        switch (strlen((string)$task)) {
            case 1:
                $num = '000'. $task;
                break;
            case 2:
                $num = '00' . $task;
                break;
            case 3:
                $num = '0' . $task;
                break;
            default:
                $num = $task;
                break;
        }

        $code = 'CV/' . $today . '/'. $num;

        return $code;
    }

    public function update($input, $id)
    {
        $data = $this->data($input);

        $task = $this->find($id);
        $data['code'] = $task->code;

        $task->update($data);

        return $task;

    }

    public function updateStatus()
    {
        $dateNow = Carbon::now()->format('Y-m-d');
        $tasks = $this->task->whereDate('date_to' ,'<' , $dateNow)->update(['task_status_id' => 6]) ;

        return $tasks;
    }
}
