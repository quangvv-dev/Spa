@extends('layout.app')
@section('content')
    <style>
        .txt-dotted {
            border: 1px solid transparent;
            border-bottom: dotted 1px #999;
            width: 100%;
            padding: 0px;
        }

        .users-summary {
            display: inline-block;
            width: 30px;
            height: 30px;
        }

        .users-summary .userlink {
            background: rgb(230, 230, 230);
            overflow: hidden;
            text-indent: -10000px;
            border-radius: 50%;
            margin-left: 0;
        }

        .beacon-green, .beacon-red {
            opacity: 0.8;
            width: 120px;
            color: #fff !important;
            border-radius: 4px;
            font-size: .8em;
            display: inline-flex;
            padding: 5px 10px;
            justify-content: center;
        }

        .beacon-green {
            background: #49CE7E;
        }

        .beacon-red {
            background: #FB5E5A;
        }

        .nav-link.active {
            font-weight: bold;
        }

        .detail-section {
            margin-bottom: 24px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .detail-section-title {
            font-weight: 700;
            padding: 10px;
            background: #f7f8f9;
            margin-bottom: 12px;
            border-radius: 3px;
        }

        .detail-group-field {
            display: flex;
            flex-wrap: wrap;
        }

        .detail-group-field > .detail-row {
            width: 50%;
        }

        .detail-row {
            margin-bottom: 12px;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chi tiết đơn</h3></br>
                {{--<form action="{{url()->current()}}" method="get" id="gridForm">--}}
                {{--<div class="ml-5">--}}
                {{--<input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">--}}
                {{--</div>--}}
                {{--</form>--}}

            </div>
            <div id="registration-form">
                <div class="mt-3 mb-3">
                    <nav class="nav">
                        {{--<a class="nav-link active" href="#">Chi tiết</a>--}}
                        {{--<a class="nav-link" href="#">Đơn khác</a>--}}
                        {{--<a class="nav-link" href="#">Đính kèm</a>--}}
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="detail-section">
                            <div class="detail-section-title"
                                 style="display: flex;align-items: center;justify-content: space-between;">Thông tin
                                chung
                                <div class="">
                                    @if($order->status === 0)
                                        @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                                            <button class="btn btn-primary acceptOrder">Duyệt đơn</button>
                                        @endif
                                        @if(\Illuminate\Support\Facades\Auth::id() == $order->user_id)
                                            <a href="/approval/order/edit/{{$order->id}}">
                                                <button class="btn btn-secondary">Sửa</button>
                                            </a>
                                            <button class="btn btn-danger delete" data-id="{{$order->id}}"
                                                    data-url="/approval/order/{{$order->id}}">Xoá
                                            </button>
                                        @endif
                                    @endif

                                </div>
                            </div>
                            <div class="detail-section-content">
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Họ và tên</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">
                                                <a href="">{{@$order->user->full_name}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Phòng ban</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">
                                                <span title="">{{@$order->user->department->name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Chức vụ</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">
                                                {{@$order->user->roles->name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Loại đơn</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">
                                               Đơn xin nghỉ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Lý do</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">{{@$order->reason->name}}</div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Tính công</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">Không</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Trạng thái</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content bold">
                                                <div
                                                    class="{{$order->status==1 ? "beacon-green" : ($order->status==0 ? "beacon-red" : 'beacon-red')}}"
                                                    style="opacity:0.8;width:120px">
                                                    {{$order->status==1 ? "Đã duyệt" : ($order->status==0 ? "Chờ duyệt" : 'Không duyệt')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField" style="width: 100%;">
                                        <div class="col-12">
                                            <div class="detail-label">Mô tả</div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="detail-content" style="color: black">{{$order->description}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-section">
                            <div class="detail-section-title">Chi tiết</div>
                            <div class="detail-section-content">
                                <div class="detail-group-field">
                                    <div
                                        class="table pop-done pop-control pop-control-contextmenu pop-connect table-align-complete"
                                        v="table" style="width: 60%;">
                                        <div class="table-header hidden" _n="header">


                                            <div class="table-checked-actions hidden" _n="checkedActions"></div>
                                            <div style="flex-grow: 1"></div>

                                        </div>

                                        <div class="table-body draggable-done" _n="body" draggable="false"
                                             _draggable="true">
                                            <div class="table-pages hidden" _n="page">
                                                <div class="table-tool" title="Phóng to, thu nhỏ"></div>
                                                <div class="table-btn-setting" _n="btnSetting"></div>
                                                <div style="flex-grow: 1"></div>
                                                <div class="table-page-title" _n="pageTitle"></div>
                                                <div class="table-page-action table-page-jump" _n="pageJump"
                                                     title="Chọn trang"><i class="icon-search"></i></div>
                                                <a class="table-page-action table-page-prev icon-caret-left"
                                                   _n="pagePrev"></a>
                                                <a class="table-page-action table-page-next icon-caret-right"
                                                   _n="pageNext"></a>
                                            </div>
                                            <table _n="table" class="table-done" remove-node-monitor="1"
                                                   add-node-monitor="1" style="table-layout: auto; width: 100%;">
                                                <colgroup></colgroup>
                                                <tbody>
                                                <tr class="table-row-header" r="0">
                                                    <td class="_s _r0 _c0 _r0c0 __r0 __c0"
                                                        style="width: 27%; min-width: 283.844px;">Bắt đầu
                                                    </td>
                                                    <td class="_s _r0 _c1 _r0c1 __r0 __c1"
                                                        style="width: 26%; min-width: 278.188px;">Kết thúc
                                                    </td>
                                                    <td style="text-align: center; width: 20%; min-width: 218.875px;"
                                                        class="_s _r0 _c2 _r0c2 __r0 __c2">Số ngày
                                                    </td>
                                                    <td style="text-align: center; min-width: 259.781px;"
                                                        class="_s _r0 _c3 _r0c3 __r0 __c3">Thời gian theo ca
                                                    </td>
                                                </tr>
                                                <tr class="table-row-body" r="1">
                                                    <td class="_s _r1 _c0 _r1c0 __r1 __c0">{{$order->TimeText}} {{\Carbon\Carbon::parse($order->date)->format('d-m-Y')}}</td>
                                                    <td class="_s _r1 _c1 _r1c1 __r1 __c1">{{$order->TimeEndText}} {{\Carbon\Carbon::parse($order->date_end)->format('d-m-Y')}}</td>
                                                    <td style="text-align:center" class="_s _r1 _c2 _r1c2 __r1 __c2">
                                                        {{$order->DateText['so_ngay']}}
                                                    </td>
                                                    <td style="text-align:center" class="_s _r1 _c3 _r1c3 __r1 __c3">
                                                        {{$order->DateText['so_ngay_cong']}}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="table-empty-message hidden">Không tìm thấy kết quả nào</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
    <input type="hidden" class="orderId" value="{{$order->id}}">

    @include('cham_cong.order.modal_accept')
@endsection
@section('_script')
    <script>
        $(document).on('click','.acceptOrder',function () {
            $('#myModalDuyet').modal('show');
        })

        $(document).on('click','.submitAccept',function () {
            let favorite = [$('.orderId').val()];
            let type = 0; //đơn nghỉ

            $.ajax({
                url:'/approval/update-array-order',
                method: 'put',
                data:{
                    array_id: favorite,
                    type: type
                },
                success:function (data) {
                    if(data){
                        alertify.success('Cập nhật thành công !');
                        location.reload();
                    } else {
                        alertify.error('Cập nhật không thành công !');
                    }
                }
            })
        })
    </script>
@endsection
