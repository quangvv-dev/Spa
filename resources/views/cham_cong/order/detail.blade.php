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

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn từ</h3></br>
                {{--<form action="{{url()->current()}}" method="get" id="gridForm">--}}
                {{--<div class="ml-5">--}}
                {{--<input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">--}}
                {{--</div>--}}
                {{--</form>--}}

            </div>
            <div id="registration-form">
                <div class="mt-3 mb-3">
                    <nav class="nav">
                        <a class="nav-link active" href="#">Chi tiết</a>
                        <a class="nav-link" href="#">Đơn khác</a>
                        <a class="nav-link" href="#">Đính kèm</a>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="detail-section">
                            <div class="detail-section-title">Thông tin chung</div>
                            <div class="detail-section-content">
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Họ và tên</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content"><a
                                                        href="/personnel-profile-profile/view?ID=375">Nguyễn
                                                    Minh Tiến</a></div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Phòng ban</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content"><span
                                                        title="HÀ NỘI › Phòng Công nghệ">Phòng Công nghệ</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Vị trí</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content"></div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Chức vụ</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Lý do</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content">Nghỉ ốm</div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Tính công</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content">Không</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Trạng thái</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content">
                                                <div class="beacon-green" style="opacity:0.8;width:120px">Đã duyệt</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-row row" v="detailField">
                                        <div class="col-5">
                                            <div class="detail-label">Ý kiến người duyệt</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="detail-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-group-field">
                                    <div class="detail-row row" v="detailField" style="width: 100%;">
                                        <div class="col-12">
                                            <div class="detail-label">Mô tả</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="detail-content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-section">
                            <div class="detail-section-title">Chi tiết</div>
                            <div class="detail-section-content">
                                <div class="detail-group-field">
                                    <div class="table pop-done pop-control pop-control-contextmenu pop-connect table-align-complete"
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
                                                    <td class="_s _r1 _c0 _r1c0 __r1 __c0">08:30 13/02/2023</td>
                                                    <td class="_s _r1 _c1 _r1c1 __r1 __c1">18:00 14/02/2023</td>
                                                    <td style="text-align:center" class="_s _r1 _c2 _r1c2 __r1 __c2"> 1
                                                        ngày 9.5 giờ
                                                    </td>
                                                    <td style="text-align:center" class="_s _r1 _c3 _r1c3 __r1 __c3">2
                                                        (ngày)
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
@endsection
@section('_script')
    <script>
    </script>
@endsection
