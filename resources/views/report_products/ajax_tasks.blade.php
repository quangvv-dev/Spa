<div class="table-responsive">
    <table class="table card-table table-center text-nowrap table-bordered table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Tổng số công việc</th>
            <th class="text-white text-center">Mới</th>
            <th class="text-white text-center">Hoàn thành</th>
            <th class="text-white text-center">Quá hạn</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($data))
            @foreach($data as $k => $s)
                <tr>
                    <td class="text-left">
                        <img src="{{@$s->user->avatar}}" width="50" height="50" class="rounded-circle">
                        {{@$s->user->full_name}}
                    </td>
                    <td class="text-center">{{@number_format($s->count)}}</td>
                    <td class="text-center">{{@number_format($s->new)}}</td>
                    <td class="text-center">{{@number_format($s->success)}}</td>
                    <td class="text-center">{{@number_format($s->count - $s->new - $s->success)}}</td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
    </table>
</div>
