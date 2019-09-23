<style>
    .page-header {
        display: none;
    }

    /*@media only screen and (max-width: 1439px) {*/
    /*.table-ajax{*/
    /*width: 71%;*/
    /*}*/
    /*}*/
    /*@media only screen and (min-width: 1440px) {*/
    /*.table-ajax{*/
    /*width: 50%;*/
    /*}*/
    /*}*/
</style>
<div class="table-responsive" style="position: relative">
    <table class="table card-table table-vcenter text-nowrap table-primary" style="width: 100%">
        <colgroup>
            <col style="width: 50px;">
            <col style="width: 50px;">
            <col style="width: 70px;">
            <col style="width: 150px;">
            <col style="width: 50px;">
            <col style="width: 150px;">
            <col style="width: 50px;">
        </colgroup>
        <thead class="bg-primary text-white">
        <tr>
            <th style="width:3%"><input type="checkbox" class="selectall myCheck"/></th>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Ngày tạo KH</th>
            <th class="text-white text-center">Họ tên</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Nhóm KH</th>
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Mô tả</th>
            <th class="text-white text-center">Người tạo KH</th>
            <th class="text-white text-center">Nguồn KH</th>
            <th class="text-white text-center">Link FB</th>
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
            @foreach($customers as $key => $customer)
                <tr>
                    <td class="text-center"
                        style="background: {{isset($customer->status)?$customer->status->color :''}}"><input
                                type="checkbox" name="delete[]" class="myCheck" value="{{$customer->id}}"/></td>
                    {{--<td class="text-center">--}}
                    {{--@if(\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::ADMIN--}}
                    {{--||\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::WAITER)--}}
                    {{--                            <a title="Đặt lịch" class="btn" href="{{ route('schedules.index', $customer->id) }}"><i class="fas fa-calendar-alt"></i></a>--}}
                    {{--                            <a title="Tạo đơn hàng" class="btn" href="{{ url('orders') }}"><i class="fas fa-file-invoice-dollar"></i></a>--}}
                    {{--<a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)"--}}
                    {{--data-url="{{ route('customers.destroy', $customer->id) }}"><i--}}
                    {{--class="fas fa-trash-alt"></i></a>--}}
                    {{--@endif--}}
                    {{--                        <a title="Trao đổi" class="btn" href="{{ url('group_comments/'. $customer->id) }}"><i class="fas fa-users"></i></a>--}}
                    {{--</td>--}}
                    <td class="text-center"></td>
                    <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($customer->created_at)) }}</td>
                    <td class="text-center"><a
                                href="{{ route('customers.show', $customer->id) }}">{{ $customer->full_name }}</a></td>
                    <td class="text-center">{{ $customer->phone }}</td>
                    <td class="text-center category-db"
                        data-id="{{$customer->id}}">
                        @foreach($customer->categories as $category)
                            {{ $category->name }},
                        @endforeach
                    </td>
                    <td class="text-center " data-id="{{$customer->id}}">{{ @$customer->status->name }}</td>
                    <td class="text-center">{{ @$customer->telesale->full_name }}</td>
                    <td class="text-center description" data-id="{{$customer->id}}"
                        style="width: 291px; height: 59px; background-color: rgb(255, 255, 255); resize: none; min-width: 291px; max-width: 291px; overflow-y: hidden;">{{ $customer->description }}</td>
                    <td class="text-center">{{ @$customer->marketing ? @$customer->marketing->full_name: '' }}</td>
                    <td class="text-center">{{ @$customer->source_customer->name}}</td>
                    <td class="text-center">{{ @$customer->facebook}}</td>
                    <td class="text-center">{{ $customer->gender_text  }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($customer->birthday)) }}</td>
                    <td class="text-center">{{ $customer->account_code }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('gross_revenue')) }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('gross_revenue')) }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('the_rest')) }}</td>
                    <td class="text-center">
                        <a title="Sửa tài khoản" class="btn" href="{{ route('customers.edit', $customer->id) }}"><i
                                    class="fas fa-edit"></i></a>
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
</div>
<div class="table-ajax" style="position: absolute; top: 121px; left: 0; overflow: hidden">
    <div style="overflow: hidden">
        <table class="table card-table table-vcenter text-nowrap table-primary" style="width: 100%">
            <colgroup>
                <col style="width: 50px;">
                <col style="width: 50px;">
                <col style="width: 70px;">
                <col style="width: 150px;">
                <col style="width: 50px;">
                <col style="width: 150px;">
                <col style="width: 50px;">
            </colgroup>
            <thead class="bg-primary text-white">
            <tr>
                <th><input type="checkbox" class="selectall myCheck"/></th>
                <th class="text-white text-center">STT</th>
                <th class="text-white text-center">Ngày tạo KH</th>
                <th class="text-white text-center">Họ tên</th>
                <th class="text-white text-center">SĐT</th>
                <th class="text-white text-center">Nhóm KH</th>
                <th class="text-white text-center">Trạng thái</th>
            </tr>
            </thead>
            <tbody style="background: white;">
            @if (count($customers))
                @foreach($customers as $key => $customer)
                    <tr>
                        <td class="text-center"
                            style="background: {{isset($customer->status)?$customer->status->color :''}}; height: 63px">
                            <input
                                    type="checkbox" name="delete[]" class="myCheck" value="{{$customer->id}}"/></td>
                        <td class="text-center">{{ $rank ++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($customer->created_at)) }}</td>
                        <td class="text-center"><a
                                    href="{{ route('customers.show', $customer->id) }}">{{ $customer->full_name }}</a>
                        </td>
                        <td class="text-center">{{ $customer->phone }}</td>
                        <td class="text-center category-db"
                            data-id="{{$customer->id}}">
                            @foreach($customer->categories as $category)
                                {{ $category->name }},
                            @endforeach
                        </td>
                        <td class="text-center status-db"
                            data-id="{{$customer->id}}">{{ @$customer->status->name }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    {{--<td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>--}}
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="pull-left">
    <div class="page-info">
        {{ 'Tổng số ' . $customers->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
    </div>
</div>
<div class="pull-right">
    {{ $customers->appends(['search' => request()->search ])->links() }}
</div>
<!-- table-responsive -->
