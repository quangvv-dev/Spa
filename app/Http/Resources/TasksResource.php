<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if ($request->api_type == 'list_tasks') {
            return [
                'id' => @$this->id,
                'name' => @$this->name,
                'date_from' => @$this->date_from,
                'time_from' => @$this->time_from,
                'user' => isset($this->user) ? [
                    'id' => @$this->user->id,
                    'full_name' => @$this->user->full_name,
                ] : null,
                'description' => @$this->description,
                'task_status' => isset($this->task_status) ? [
                    'id' => @$this->task_status->id,
                    'full_name' => @$this->task_status->name,
                ] : null,
                'type' => @$this->type ? [
                    'id' => $this->type,
                    'name' => Task::TYPE[$this->type]??null
                ] : null,
            ];
        }
        return [
            'id' => @$this->id,
            'full_name' => @$this->full_name,
            'all_task' => @$this->all_task,
            'all_done' => @$this->all_done,
            'all_failed' => @$this->all_failed,
        ];
    }
}
