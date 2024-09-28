<div class="table-responsive">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Quyền</th>
            <th class="text-white text-center">Phòng ban</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @forelse($docs as $k => $item)
            <tr>
                <th scope="row">{{$k+1}}</th>
                <td class="text-center">{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td class="text-center">{{$item->name}}</td>
                <td class="text-center">{{@$item->department->name}}</td>

                <td class="text-center">
                    <a class="primary btn"
                       href="{{ route('roles.edit', $item->id) }}"><i
                                class="fa fa-edit"></i></a>


{{--                    @if($item->id == \App\Constants\Setting::ADMIN || $item->id == \App\Constants\Setting::ROLE_KHACH_HANG)--}}
{{--                        <a class=" mr-1 user-now"--}}
{{--                           title="Người dùng đang đăng nhập"><i--}}
{{--                                    class="fa fa-trash-o"></i></a>--}}
{{--                    @else--}}
{{--                        <a class="danger mr-1 delete-item user-now " data-id="{{ $item->id }}"--}}
{{--                           title="Người dùng đang đăng nhập"><i--}}
{{--                                    class="fa fa-trash-o"></i></a>--}}
{{--                    @endif--}}
                </td>
            </tr>
        @empty
            <tr>
                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

