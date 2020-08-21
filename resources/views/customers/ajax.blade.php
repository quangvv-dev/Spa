<style>
    .page-header {
        display: none;
    }
    .display {
        display: inline-block;
        vertical-align: top;
    }
    .dropdown, .dropup {
        position: relative;
    }
    .gf-icon-filter {
        /*background-position: -758px -284px;*/
        width: 28px;
        height: 20px;
    }
</style>
<div class="card-header filter-box">
    <div class="display btn-group open">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"
                style="height: 39px; border-radius: 3px; margin-right: 10px"><i
                    class="fa fa-caret-down"></i></button>
        <ul class="dropdown-menu">
            <li class="pd5" id="search"><a class="invalid_account" data-invalid="1"
                                           data-icon-class="fa fa-trash">
                    <span class="pr10"></span> Đang sử dụng </a>
            </li>
            <li class="pd5"><a class="invalid_account" data-invalid="0"
                               data-icon-class="fa fa-dot-circle-o"> <span class="pr10"><i
                                class="fa fa-dot-circle-o" aria-hidden="true"></i></span> Đã xoá </a>
            </li>
        </ul>
    </div>
    <div class="display btn-group" id="btn_tool_group" style="display: none;">
        <button type="button" class="btn btn-default position dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"> Thao tác <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li class="dropdown_action" id="send_email"><a>Gửi Email</a></li>
            <li class="dropdown_action" id="send_sms"><a>Gửi SMS</a></li>
            <li class="dropdown_action" id="mark_as_potential"><a>Tạo cơ hội</a></li>
            <li class="dropdown_action" id="show_popup_task"><a>Tạo công việc</a></li>
            <li class="dropdown_action" id="show_group_type_account"><a>Nhóm khách hàng</a></li>
            <li class="dropdown_action" id="show_manager_account"><a>Người phụ trách</a></li>
            <li class="dropdown_action" id="remove_selected_account"><a>Xóa nhiều</a></li>
            <li class="dropdown_action" id="restore_account" style="display: none;"><a>Khôi phục</a></li>
            <li class="dropdown_action" id="permanently_delete_account" style="display: none;"><a>Xóa
                    hẳn</a></li>
            <li class="dropdown_action"><a id="change_relations">Mối quan hệ</a></li>
        </ul>
    </div>
    <div style="margin-left: 10px">
        <button data-name="" class="btn btn-default status btn white account_relation position"
                style="height: 40px;">
            TẤT CẢ
            <span class="not-number-account white">{{ $customers->total() }}</span>
        </button>
    </div>
    <div style="margin-left: 10px">
        <button class="btn btn-default" style="height: 40px;">
            <a href="{{ route('status.create') }}">
                <i class="fa fa-plus font16"></i>
            </a>
        </button>
    </div>
    <div class="scrollmenu col-md-7">
        @foreach(@$statuses as $k => $item)
            <button class="status btn white account_relation position" data-name="{{$item->name}}"
                    style="background: {{$item->color ?:''}}">{{ $item->name }}<span
                        class="not-number-account white">{{ $item->customers->count() }}</span></button>
        @endforeach
    </div>
    <div class="col-md-2 row" style="margin-top: 10px;color: black; font-weight: bold; justify-content: center;
    align-items: baseline;">
        <div style="float: right">
            <span>{{$customers->firstItem()}} - {{$customers->lastItem()}}</span>
        </div>
        <div style="float: right">
            {{ $customers->appends(['search' => request()->search ])->links('vendor.pagination.simple-bootstrap-4') }}
        </div>
    </div>
    <div class="col-md-2">
        <div class="display birthday_tab position font20 pointer mt7" rel="tooltip" data-placement="left"
             data-original-title="Sinh nhật hôm nay"
             aria-describedby="tooltip146058"><i class="fa fa-birthday-cake gf-icon-h02"
                                                 aria-hidden="true"></i><span class="not-number-account"
                                                                              style="background: rgb(249, 87, 87); color: rgb(255, 255, 255); display: none;"></span>
        </div>
        <div class="display" style="width: 28px; height: 20px;">
            <div class="dropdown open"><i class="fa fa-eye dropdown-toggle" role="button"
                                          data-toggle="dropdown" title="Hiển thị số trang" aria-expanded="true" style="margin-top: 8px; margin-left: 5px;"></i>
                <ul class="dropdown-menu pull-right tl mt5" role="menu" style="border-top:1px">
                    <li><a class="b-white b-hover limiting active_limit bold" data-limit="20">Hiển thị 20 kết
                            quả/trang</a></li>
                    <li><a class="b-white b-hover limiting" data-limit="50">Hiển thị 50 kết quả/trang</a></li>
                    <li><a class="b-white b-hover limiting" data-limit="100">Hiển thị 100 kết quả/trang</a></li>
                    <li><a class="b-white b-hover limiting" data-limit="200">Hiển thị 200 kết quả/trang</a></li>
                    {{--<li><a class="b-white b-hover limiting" data-limit="500">Hiển thị 500 kết quả/trang</a></li>--}}
                    {{--<li><a class="b-white b-hover limiting" data-limit="1000">Hiển thị 1000 kết quả/trang</a></li>--}}
                </ul>
            </div>
        </div>
        <div id="div_created_at_dropdown"
             class="display position pointer mt5 open" rel="tooltip"
             data-placement="left" data-original-title="Thời gian tạo khách hàng"
             style="padding-left: 5px"><a class="dropdown-toggle" data-toggle="dropdown"
                                          aria-expanded="true"><i id="created_at_icon"
                                                                  class="far fa-clock"
                                                                  style="font-size:22px"></i></a>
            <ul class="dropdown-menu pull-right tr">
                <li class="created_at_item bor-bot tc"><a data-time="TODAY" class="btn_choose_time">Hôm
                        nay</a>
                </li>
                <li class="created_at_item bor-bot tc"><a data-time="YESTERDAY" class="btn_choose_time">Hôm
                        qua</a></li>
                <li class="created_at_item bor-bot tc"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần
                        này</a></li>
                <li class="created_at_item bor-bot tc"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần
                        trước</a></li>
                <li class="created_at_item bor-bot tc"><a data-time="THIS_MONTH" class="btn_choose_time">Tháng
                        này</a></li>
                <li class="created_at_item bor-bot tc"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng
                        trước</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="table-responsive" style="position: relative">
    <table class="table card-table table-vcenter text-nowrap table-primary" style="width: 100%">
        <thead class="bg-primary text-white">
        <tr>
            <th style="width:3%"><input type="checkbox" class="selectall myCheck"/></th>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Ngày tạo KH</th>
            <th class="text-white text-center">Họ tên</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Nhóm KH</th>
            <th class="text-white text-center" style="width: 200px">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
            <th class="text-white text-center">Người phụ trách</th>
            <th class="text-white text-center">Mô tả</th>
            <th class="text-white text-center">Ngày sinh</th>
            <th class="text-white text-center">Người tạo KH</th>
            <th class="text-white text-center">Nguồn KH</th>
            <th class="text-white text-center">Link FB</th>
            <th class="text-white text-center">Giới tính</th>
            <th class="text-white text-center">Mã KH</th>
            <th class="text-white text-center">Số đơn</th>
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
                        style="background: {{isset($customer->status)?$customer->status->color :''}}">
                        <input type="checkbox" name="delete[]" class="myCheck" value="{{$customer->id}}"/></td>
                    <td class="text-center"></td>
                    <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($customer->created_at)) }}</td>
                    <td class="text-center">
                        <a href="#"><i class="fas fa-info-circle"></i></a>
                        <a href="{{ route('customers.show', $customer->id) }}">{{ $customer->full_name }}</a>
                        <span class="noti-number noti-number-on ml5"
                              style="background-color: #ee630c!important;">2</span>
                    </td>
                    <td class="text-center">{{ $customer->phone }}</td>
                    <td class="text-center category-db"
                        data-id="{{$customer->id}}">
                        @foreach($customer->categories as $category)
                            {{ $category->name }},
                        @endforeach
                    </td>
                    <td class="text-center " data-id="{{$customer->id}}"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                    <td class="text-center telesale-customer"
                        data-customer-id="{{$customer->id}}">{{ @$customer->telesale->full_name }}</td>
                    <td class="text-center description-cus" data-id="{{$customer->id}}"
                        style="width: 291px; height: 59px; background-color: rgb(255, 255, 255); resize: none; min-width: 291px; max-width: 291px; overflow-y: hidden;">{{ $customer->description }}</td>
                    <td class="text-center customer-birthday" data-id="{{$customer->id}}">{{ date('d-m-Y', strtotime($customer->birthday)) }}</td>
                    <td class="text-center">{{ @$customer->marketing ? @$customer->marketing->full_name: '' }}</td>
                    <td class="text-center">{{ @$customer->source_customer->name}}</td>
                    <td class="text-center">{{ @$customer->facebook}}</td>
                    <td class="text-center">{{ $customer->gender_text  }}</td>
                    <td class="text-center">{{ $customer->account_code }}</td>
                    <td class="text-center">{{ count($customer->orders) }}</td>
                    <td class="text-center">{{ number_format($customer->orders->sum('all_total')) }}</td>
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
<div class="table-ajax" style="position: absolute; top: 121px; left: 0; overflow: hidden; margin-top: 12px;">
    <div style="overflow: hidden">
        <table class="table card-table table-vcenter text-nowrap table-primary" style="width: 100%">
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
                        <td class="text-center">{{ date('d-m-Y H:i', strtotime($customer->created_at)) }}</td>
                        <td class="text-center name-customer" data-customer-id="{{ $customer->id }}">
                            <a class="view_modal" id="chat-fast" data-customer-id="{{ $customer->id }}" href="#">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a target="_blank" href="{{ route('customers.show', $customer->id) }}">{{ $customer->full_name }}</a>
                            <span class="noti-number noti-number-on ml5">{{ $customer->groupComments->count() }}</span>
                        </td>
                        <td class="text-center phone-customer"
                            data-customer-id="{{ $customer->id }}">{{ $customer->phone }}</td>
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
        {{ 'Tổng số ' . $customers->total() . ' khách hàng ' . (request()->search ? 'found' : '') }}
    </div>
    <div class="pull-right">
        {{ $customers->appends(['search' => request()->search ])->links() }}
    </div>
</div>
@include('customers.modal_view')
<!-- table-responsive -->
<script>
    $('.table-responsive .table-primary').floatThead({
        top: 196,
        scrollContainer: function ($table) {
            return $table.closest('');
        },
        position: 'absolute'
    });
    $('.table-ajax .table-primary').floatThead({
        top: 196,
        position: 'absolute'
    });
    $('html, body').animate({scrollTop: '0px'}, 300);
</script>
