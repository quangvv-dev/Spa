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
        $task = $this->task->where('id', $id)->with('customer', 'user')->first();
        return $task;
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return false;
        }
        $data['task_status_id'] = 1;
        unset($data['all_day']);
        $handleData = $this->data($data);
        $note = str_replace("\r\n", ' ', $handleData['description']);
        $note = str_replace("\n", ' ', $note);
        $note = str_replace('"', ' ', $note);
        $note = str_replace("'", ' ', $note);
        $handleData['description'] = $note;
        $handleData['time_from'] = !empty($data['time_from']) ? $data['time_from'] : '07:00';
        $handleData['time_to'] = !empty($data['time_to']) ? $data['time_to'] : '21:00';
        $model = $this->task->create($handleData);
        return $model;
    }

    public function insert(array $data)
    {
        if (empty($data)) return false;
        $note = str_replace("\r\n", ' ', $data['description']);
        $note = str_replace("\n", ' ', $note);
        $note = str_replace('"', ' ', $note);
        $note = str_replace("'", ' ', $note);
        $data['description'] = $note;
        $data['time_from'] = '07:00';
        $data['time_to'] = '21:00';
        $model = $this->task->create($data);
        return $model;
    }

//    public function create2(array $data)
//    {
//        if (empty($data)) {
//            return false;
//        }
//        $data['task_status_id'] = 1;
//        $a = Task::create($data);
//        dd($a);
//        return $a;
//    }

    public function data(array $data)
    {
        if (isset($data['date_from'])) {
            $data['date_from'] = Functions::yearMonthDay($data['date_from']);
        }
        $data['taskmaster_id'] = $data['taskmaster_id'] ?? Auth::user()->id;
        $data['code'] = $this->genderCode();

        if (!empty($data['file_document'])) {
            $data['document'] = $this->fileUpload->uploadDocumentFile($data['file_document']);
        }

        return $data;

    }

    public function genderCode()
    {
        $today = Carbon::parse(Carbon::now())->format('Y-m-d');

        $task = $this->task->count() + 1;

        $num = '';

        switch (strlen((string)$task)) {
            case 1:
                $num = '000' . $task;
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

        $code = 'CV/' . $today . '/' . $num;

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
        $tasks = $this->task->whereDate('date_to', '<', $dateNow)->update(['task_status_id' => 6]);

        return $tasks;
    }
}
