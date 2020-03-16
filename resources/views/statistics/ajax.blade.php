<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên nhân viên</th>
            <th class="text-white text-center">Quyền</th>
            <th class="text-white text-center">Số lượng khách hàng</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(count(@$statisticUsers))
            @foreach($statisticUsers as $k => $statisticUser)
                <tr>
                    <th scope="row">{{$k}}</th>
                    <td class="text-center">{{ @$statisticUser->marketing->full_name }}</td>
                    <td class="text-center">{{ @$statisticUser->marketing->role_text }}</td>
                    <td class="text-center">{{ $statisticUser->count }}</td>
                    <td class="text-center">
                        <a class="btn" href="{{ url('statistics/' . $statisticUser->marketing->id . '/detail') }}"><i class="far fa-eye"></i></a>
                    </td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="3">Không tồn tại dữ liệu</td>
            </tr>
        @endif
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $statisticUsers->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $statisticUsers->appends(['search' => request()->search ])->links() }}
    </div>
</div>
