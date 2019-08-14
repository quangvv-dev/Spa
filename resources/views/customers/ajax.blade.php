<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th style="width:3%"><input type="checkbox" class="selectall myCheck" onchange="myFunction()"/></th>
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
            <th class="text-white text-center">Tổng doanh thu</th>
            <th class="text-white text-center">Đã thanh toán</th>
            <th class="text-white text-center">Còn lại</th>
            <th class="text-white text-center">Chỉnh sửa</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @if (count($customers))
            @foreach($customers as $customer)
                <tr>
                    <td class="text-center" style="background: {{isset($customer->status)?$customer->status->color :''}}"><input type="checkbox" name="delid[]" class="myCheck"
                                                   onchange="myFunction()" data-id="{{$customer->id}}"/></td>
                    <td class="text-center">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::ADMIN
                        ||\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::WAITER)
                            <a title="Đặt lịch" class="btn" href="{{ route('schedules.index', $customer->id) }}"><i class="fas fa-calendar-alt"></i></a>
                            <a title="Tạo đơn hàng" class="btn" href="{{ url('orders') }}"><i class="fas fa-file-invoice-dollar"></i></a>
                        @endif
                        <a title="Trao đổi" class="btn" href="{{ url('group_comments/'. $customer->id) }}"><i class="fas fa-users"></i></a>
                        {{--<a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)" data-url="{{ route('customers.destroy', $customer->id) }}"><i class="fas fa-trash-alt"></i></a>--}}
                    </td>
                    <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($customer->created_at)) }}</td>
                    <td class="text-center">{{ $customer->full_name }}</td>
                    <td class="text-center">{{ $customer->phone }}</td>
                    <td class="text-center">{{ @$customer->category->name }}</td>
                    <td class="text-center status-db" data-id="{{$customer->id}}">{{ @$customer->status->name }}</td>
                    <td class="text-center">{{ @$customer->telesale->full_name }}</td>
                    <td class="text-center description" data-id="{{$customer->id}}" width="250">{{ $customer->description }}</td>
                    <td class="text-center">{{ @$customer->marketing ? @$customer->marketing->full_name: '' }}</td>
                    <td class="text-center">{{ @$customer->source_customer->name}}</td>
                    <td class="text-center">{{ $customer->gender_text  }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($customer->birthday)) }}</td>
                    <td class="text-center">{{ $customer->account_code }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('gross_revenue')) }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('gross_revenue')) }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('the_rest')) }}</td>
                    <td class="text-center">
                        <a title="Sửa tài khoản" class="btn" href="{{ route('customers.edit', $customer->id) }}"><i class="fas fa-edit"></i></a>
                    </td>
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
            {{ 'Tổng số ' . $customers->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $customers->appends(['search' => request()->search ])->links() }}
    </div>
</div>
<!-- table-responsive -->
