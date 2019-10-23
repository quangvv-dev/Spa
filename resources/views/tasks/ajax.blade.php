<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Tên công việc</th>
            <th class="text-white text-center">Thực hiện</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Ưu tiên</th>
            <th class="text-white text-center">Bắt đầu</th>
            <th class="text-white text-center">Kết thúc</th>
            <th class="text-white text-center">Thời gian</th>
        </tr>
        </thead>
        <tbody style="background-color: white">
            @foreach($tasks as $task)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('tasks.edit', $task->id) }}">{{$task->name}}</a></td>
                    <td class="text-center">{{@$task->user->full_name}}</td>
                    <td class="text-center">{{@$task->user->department->name}}</td>
                    <td class="text-center">{{$task->name_priority}}</td>
                    <td class="text-center">{{$task->date_from}}</td>
                    <td class="text-center">{{$task->date_to}}</td>
                    <td class="text-center"></td>
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
