<div class="title padding5-10 col-md-12 mt10">
    <div class="col-md-12 fl mt2 no-padd"><a
                class="display filter_all mr20 text-filter bold" data-task-id=""><span>Tất cả({{count($tasks)}})</span></a>
        @foreach ($taskStatus as $item)
            <a class="display filter_all mr20 text-filter bold" data-task-id="{{$item->id}}"> {{ $item->name}}
                ({{$item->tasks->count()}})</a>
        @endforeach
    </div>
</div>
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Thao tác</th>
            <th class="text-white">Công việc</th>
            <th class="text-white text-center">Thực hiện</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Ưu tiên</th>
            <th class="text-white text-center">Bắt đầu</th>
            <th class="text-white text-center">Kết thúc</th>
            <th class="text-white text-center">Trạng thái</th>
        </tr>
        </thead>
        <tbody style="background-color: white">
        @foreach($tasks as $task)
            <tr>
                <td class="text-center update-status" data-id="{{$task->id}}"><i class="fas fa-edit"></i></td>
                <td class="text-center">
                    <a href="{{ route('tasks.edit', $task->id) }}">{{$task->name}}</a></td>
                <td class="text-center">
                    <img src="{{ @$task->user->avatar }}"
                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover"></td>
                <td class="text-center">{{@$task->customer->full_name}}</td>
                <td class="text-center">{{@$task->user->department->name?:@$task->department->name}}</td>
                <td class="text-center">{{$task->name_priority}}</td>
                <td class="text-center">{{$task->date_from}}</td>
                <td class="text-center">{{$task->date_to}}</td>
                @if($task->task_status_id == 6)

                    <td class="text-center bold" style="color: red !important;">{{ @$task->taskStatus->name }}</td>
                @elseif($task->task_status_id == 3)
                    <td class="text-center bold" style="color: green !important;">{{ @$task->taskStatus->name }}</td>
                @else
                    <td class="text-center">{{ @$task->taskStatus->name }}</td>
                @endif
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{--            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
        </div>
    </div>
    <div class="pull-right">
        {{--        {{ $docs->appends(['search' => request()->search ])->links() }}--}}
    </div>
</div>
