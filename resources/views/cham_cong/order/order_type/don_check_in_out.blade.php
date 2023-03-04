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
            border: 1px solid #36c870;
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

        .form-small {
            width: 600px;
            max-width: 100%;
        }

        .form-group.form-input.form-group-select {
            width: 600px;
            max-width: 100%;
        }

        .form-body .form-section {
            padding-left: 15px;
            padding-right: 15px;
        }

        .form-small-custom {
            padding-left: 30px;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tạo mới đơn checkin/out</h3></br>
                {{--<form action="{{url()->current()}}" method="get" id="gridForm">--}}
                {{--<div class="ml-5">--}}
                {{--<input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">--}}
                {{--</div>--}}
                {{--</form>--}}

            </div>
            <div id="registration-form">
                {{--<div class="mt-3 mb-3">--}}
                {{--<nav class="nav">--}}
                {{--<a class="nav-link active" href="#">Chi tiết</a>--}}
                {{--<a class="nav-link" href="#">Đơn khác</a>--}}
                {{--<a class="nav-link" href="#">Đính kèm</a>--}}
                {{--</nav>--}}
                {{--</div>--}}
                <div class="row">
                    <div class="col-12">
                        <div class="form-body disabled-done" style="pointer-events: auto; opacity: 1;">
                            <div class="form-section">
                                <div class="detail-section-title">Thông tin chung</div>

                                <div class="form-group form-small" style="padding-right: 0px;">
                                    <div class="row form-group-body">
                                        <div class="form-group form-input form-group-control col-4">
                                            <label class="form-group-label required">Ngày</label>
                                            {{--<input placeholder="dd/mm/yyyy" class="form-control"--}}
                                            {{--autocomplete="off">--}}
                                            <input class="form-control" id="search" autocomplete="off"
                                                   data-toggle="datepicker" placeholder="dd/mm/yyyy" name="date"
                                                   type="text">
                                        </div>
                                        <div class="form-group form-input form-group-control col-4">
                                            <label class="form-group-label required">Giờ</label>
                                            {{--<input placeholder="hh:mm" class="form-control"--}}
                                            {{--autocomplete="off">--}}
                                            <select name="" id="" class="form-control">
                                                @forelse($time as $key=> $item)
                                                    <option value="{{$key}}">{{$item}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            {{--<input class="form-control" autocomplete="off" data-toggle="datepicker-hm" placeholder="dd/mm/yyyy" name="date" type="text">--}}

                                        </div>
                                        <div class="form-group form-input disabled-done form-group-control col-4"
                                             style="padding-left: 5px;">
                                            <label class="form-group-label">Ca</label>
                                            <input type="text" class="form-control" readonly="">
                                        </div>

                                        <div class="form-group form-input form-group-select form-group-control col-8"
                                             style="padding-right: 5px;">
                                            <label class="form-group-label required">Lý do</label>
                                            <form>
                                                <select name="reason" class="form-control select2">
                                                    <option></option>
                                                    <option value="1">Máy chấm công hỏng (Tối đa 2 lần / Tuần)</option>
                                                    <option value="1">Công tác (Tối đa 2 lần / Tháng)</option>
                                                    <option value="1">Quên chốt vân tay (Tối đa 1 lần / Tuần)</option>
                                                    <option value="1">Chưa có mã vân tay (Tối đa 1 lần / Tuần)</option>
                                                    <option value="1">Lý do khác (Tối đa 1 lần / Tháng)</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="form-group form-input disabled-done form-group-control col-4"
                                             style="padding-left: 5px;">
                                            <label class="form-group-label">Phạt tiền</label>
                                            <input type="text" class="form-control" readonly="" value="Có">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group form-input form-group-select">
                                    <label class="form-group-label required">Người duyệt 1</label>
                                    <form>
                                        <select name="app_approval_ids[]"
                                                class="form-control select2">
                                            <option xs-empty-option="true"></option>
                                            <option value="1">Admin</option>
                                            <option value="3">Lê Thị Thanh Hằng</option>
                                            <option value="8">Liêu Văn Ninh</option>
                                            <option value="12">Phạm Thị Khánh Ly</option>
                                            <option value="14">Ma Khắc Quang</option>
                                            <option value="16">Hoàng Thị Nhung</option>
                                            <option value="17">Nguyễn Hữu An</option>
                                            <option value="87">Nguyễn Đức Toàn</option>
                                            <option value="130">Nguyễn Trung Hiếu</option>
                                            <option value="199">Hoàng Diệu Linh</option>
                                            <option value="214">Nguyễn Thị Vân Anh</option>
                                            <option value="224">Nguyễn Thị Như Quỳnh</option>
                                            <option value="300">Vi Văn Giang</option>
                                            <option value="475">Nguyễn Thúy Hằng</option>
                                            <option value="586">Nguyễn Hoàng Thanh Thảo</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="form-group form-small form-small-custom" v="form.group">
                            <div class="row form-group-body">
                                <div class="form-group form-input form-small form-group-editor form-group-control">
                                    <label class="form-group-label">Mô tả</label>
                                    <textarea style="flex-grow:1;max-width:100%"
                                              name="desc" placeholder="Nhập mô tả"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group form-buttons">
                            <button class="btn disabled-done">Cập nhật</button>
                            <div class="btn btn-default" rel="cancel">Hủy bỏ</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table-responsive -->
    </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
            // $('[data-toggle="datepicker-hm"]').datepicker({
            //     format: 'h:i',
            //     autoHide: true,
            //     zIndex: 2048,
            // });
        });
    </script>
@endsection
