<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">ID</th>
            <th class="text-white text-center">Thao tác</th>
            <th class="text-white text-center">Ngày tạo KH</th>
            <th class="text-white text-center">Họ tên</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Nhóm KH</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Mô tả</th>
            <th class="text-white text-center">Người tạo KH</th>
            <th class="text-white text-center">Nguồn KH</th>
            <th class="text-white text-center">Giới tính</th>
            <th class="text-white text-center">Ngày sinh</th>
            <th class="text-white text-center">Mã KH</th>
            <th class="text-white text-center">Số đơn</th>
            <th class="text-white text-center">Tổng doanh thu</th>
            <th class="text-white text-center">Giá trị đơn</th>
        </tr>
        </thead>
        <tbody>
        @if (count($users))
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td class="text-center">
                        <a title="Đặt lịch" class="btn" href="{{ route('schedules.index', $user->id) }}"><i class="fas fa-calendar-alt"></i></a>
                        <a title="Sửa tài khoản" class="btn" href="{{ route('customers.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
                        <a title="Tạo đơn hàng" class="btn" href="{{ url('orders') }}"><i class="fas fa-file-invoice-dollar"></i></a>
                        <a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)" data-url="{{ route('customers.destroy', $user->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>
                    <td class="text-center">{{ $user->full_name }}</td>
                    <td class="text-center">{{ $user->phone }}</td>
                    <td class="text-center">{{ @$user->category->name }}</td>
                    <td class="text-center">{{ @$user->status->name }}</td>
                    <td class="text-center">{{ @$user->telesale->full_name }}</td>
                    <td class="text-center">{{ $user->description }}</td>
                    <td class="text-center">{{ @$user->marketing ? @$user->marketing->full_name: '' }}</td>
                    <td class="text-center">{{ @$user->source->name}}</td>
                    <td class="text-center">{{ $user->gender_text  }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($user->birthday)) }}</td>
                    <td class="text-center">{{ $user->account_code }}</td>
                    <td class="text-center">{{ $user->orders->count() }}</td>
                    <td class="text-center">{{ number_format($user->orders->sum('all_total')) }}</td>
                    <td class="text-center"></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $users->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $users->appends(['search' => request()->search ])->links() }}
    </div>
</div>
<!-- table-responsive -->
