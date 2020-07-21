{{--<div class="title padding5-10 col-md-12 mt10">--}}
    {{--<div class="col-md-12 fl mt2 no-padd"><a--}}
            {{--class="display filter_all mr20 text-filter bold" data-task-id=""><span>Tất cả({{count($tasks)}})</span></a>--}}
        {{--@foreach ($taskStatus as $item)--}}
            {{--<a class="display filter_all mr20 text-filter bold" data-task-id="{{$item->id}}"> {{ $item->name}}--}}
                {{--({{$item->tasks->count()}})</a>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Thao tác</th>
            <th class="text-white">Công việc</th>
            <th class="text-white text-center">Thực hiện</th>
            <th class="text-white text-center">Ngày thực hiện</th>
            <th class="text-white text-center">Khoảng thời gian</th>
            <th class="text-white text-center">Trạng thái</th>
        </tr>
        </thead>
        <tbody style="background-color: white">
        @foreach($tasks as $task)
            <tr>
                @if($task->task_status_id ==1)
                    <td class="text-center update-status" data-id="{{$task->id}}"><i class="fas fa-edit"></i></td>
                @else
                    <td class="text-center">
                        <i class="fa fa-check-square" aria-hidden="true"></i>
                    </td>


                @endif
                <td class="text-center">
                    <a href="{{ route('tasks.edit', $task->id) }}">{{$task->name}}</a></td>
                <td class="text-center">
                    @if(@$task->user->avatar)
                        <img src="{{ @$task->user->avatar }}"
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover">
                    @else
                        <img src="{{ asset('/images/users/default-avatar-profile-icon-vector-18942381.jpg') }}"
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover">
                    @endif
                </td>
                <td class="text-center">{{$task->date_from}}</td>
                <td class="text-center">{{$task->time_from.' - '.$task->time_to}}</td>
                @if(@$task->task_status_id == 6)
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
<script>
    $('.update-status').click(function () {
        const id = $(this).data('id');
        swal({
            title: 'Bạn có muốn hoàn thành công việc ?',
            type: "success",
            showCancelButton: true,
            cancelButtonClass: 'btn-secondary waves-effect',
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'OK'
        }, function () {
            $.ajax({
                type: 'POST',
                url: '/ajax/tasks/update',
                data: {
                    id: id,
                },
                success: function () {
                    window.location.reload();
                }
            })
        })
    });
</script>
