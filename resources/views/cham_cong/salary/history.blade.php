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
        .users-summary .userlink{
            background: rgb(230, 230, 230);
            overflow: hidden;
            text-indent: -10000px;
            border-radius: 50%;
            margin-left: 0;
        }
        .beacon-green,.beacon-red {
            opacity: 0.8;
            width: 120px;
            border: 1px solid #36c870;
            color: #fff!important;
            border-radius:4px;
            font-size: .8em;
            display: inline-flex;
            padding: 5px 10px;
            justify-content: center;
        }
        .beacon-green{
            background: #49CE7E;
        }
        .beacon-red {
            background: #FB5E5A;
        }
        .nav-link.active{
            font-weight: bold !important;
        }
        .pointer{
            cursor: pointer;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách</h3></br>
                <form action="{{url()->current()}}" method="get" id="gridForm">
                    <div class="ml-5">
                        <input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">
                    </div>
                </form>
                <div class="col">
                    <a 1="" title="Upload Data" style="position: absolute;right: 0%" href="#" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-cloud-upload-alt"></i></a>
                    <a 1="" title="Tải data" style="position: absolute;right: 3%" class="download" data-value="dowload" href="javascript:void(0)"><i class="fas fa-cloud-download-alt"></i></a>
                </div>

            </div>
            <div id="registration-form">
                {{--<div class="mt-3 mb-3">--}}
                {{--<nav class="nav">--}}
                {{--<a class="nav-link active" href="#">Tất cả (11)</a>--}}
                {{--<a class="nav-link" href="#">Chờ duyệt (12)</a>--}}
                {{--<a class="nav-link" href="#">Đã duyệt (45)</a>--}}
                {{--<a class="nav-link" href="#">Không duyệt</a>--}}
                {{--</nav>--}}
                {{--</div>--}}
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-primary">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">TT</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($docs as $key=> $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="/approval/detail-history-salary/{{$item->id}}">{{$item->name}}</a></td>
                                <td>
                                    <div class="{{$item->status == 0 ? 'beacon-red' : 'beacon-green'}}" style="opacity:0.8;width:120px">
                                        {{$item->status == 0 ? 'Huỷ' : 'Đã chuyển'}}
                                    </div>
                                </td>
                                <td>
                                    @if($item->status == 1)
                                        <button class="btn btn-sm btn-danger destroy" title="Huỷ bảng lương">Huỷ</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td colspan="5">Không có dữ liệu</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
            <!-- table-responsive -->
        </div>
    </div>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="full_name">Thêm bảng lương</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/approval/import-salary')}}" accept-charset="UTF-8" id="fvalidate" enctype="multipart/form-data" autocomplete="off"><input name="_token" type="hidden" value="yLACOlxlQB9ZaPJ1gQSVkUSjh9RZ6Rpu3rf3xz1M">

                        <div class="row">
                            <div class="col-12">
                                <label for="">Tên bảng lương</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Chọn tháng</label>
                                <input class="form-control datepicker" autocomplete="off" data-toggle="datepicker" placeholder="mm/yyyy" name="date" type="text" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <i style="color: red">Vui lòng tải file excel (*xlsx)</i><br><br>
                                <label class="btn btn-primary">
                                    Browse… <input required="" name="file" type="file" style="display: none">
                                </label>
                            </div>
                            <div class="col-md-12" style="padding-top: 10px">
                                <button type="submit" class="btn btn-success">Lưu</button>
                                <a href="http://spa.test/default/data-orders-default.xlsx" style="color: #ffffff" class="btn btn-warning">Mẫu
                                    upload</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    {{--<script src="{{asset('js/datepicker.js')}}"></script>--}}
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'mm-yyyy',
                autoHide: true,
                zIndex: 2048

            });
            // // $('[data-toggle="datepicker-hm"]').datepicker({
            // //     format: 'h:i',
            // //     autoHide: true,
            // //     zIndex: 2048,
            // // });
            // $('.datepicker').datepicker('setDate', 'now');
            // $.fn.datepicker.dates['en'] = {
            //     months: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu", "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
            //     monthsShort: ["Thg 1", "Thg 2", "Thg 3", "Thg 4", "Thg 5", "Thg 6", "Thg 7", "Thg 8", "Thg 9", "Thg 10", "Thg 11", "Thg 12"],
            //     today: "Today",
            //     clear: "Clear",
            //     titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
            //     weekStart: 0,
            // };
        });
        $(function () {
            $(".draggable").draggable();
        });
        $(document).on('click', '#checkAll', function () {
            if (this.checked) {
                $('input:checkbox[getdataitem]').not(this).prop('checked', true);
            } else {
                $('input:checkbox[getdataitem]').not(this).prop('checked', false);
            }
        })


        // let array_HOURS = [{
        //     '00:00': 0,
        //     '00:30': 0.5,
        //     '01:00':1,
        //     '01:30':1.5,
        //     '02:00':2,
        //     '02:30':2.5,
        //     '03:00':3,
        //     '03:30':3.5,
        //     '04:00':4,
        //     '04:30':4.5,
        //     '05:00':5,
        //     '05:30':5.5,
        //     '06:00':6,
        //     '06:30':6.5,
        //     '07:00':7,
        //     '07:30':7.5,
        //     '08:00':8,
        //     '08:30':8.5,
        //     '09:00':9,
        //     '09:30':9.5,
        //     '10:00':10,
        //     '10:30':10.5,
        //     '11:00':11,
        //     '11:30':11.5,
        //     '12:00':12,
        //     '12:30':12.5,
        //     '13:00':13,
        //     '13:30':13.5,
        //     '14:00':14,
        //     '14:30':14.5,
        //     '15:00':15,
        //     '15:30':15.5,
        //     '16:00':16,
        //     '16:30':16.5,
        //     '17:00':17,
        //     '17:30':17.5,
        //     '18:00':18,
        //     '18:30':18.5,
        //     '19:00':19,
        //     '19:30':19.5,
        //     '20:00':20,
        //     '20:30':20.5,
        //     '21:00':21,
        //     '21:30':21.5,
        //     '22:00':22,
        //     '22:30':22.5,
        //     '23:00':23,
        //     '23:30':23.5
        // }];

        $(document).on('click','.showModal',function () {
            let dt = new Date();
            let elm = $(this);
            let month = dt.getMonth() + 1 < 10 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
            let date1 = elm.data('date') <10 ? '0'+ elm.data('date') :  elm.data('date');
            let date = `${date1}-${month}-${dt.getFullYear()}`;
            let date_check  =  `${dt.getFullYear()}-${month}-${date1} 13:30:00`; //giờ ca chiều
            let user_id = elm.closest('tr').data('id');

            let cong = elm.html();
            let cong_an = cong > 0.8 ? 1 : 0;
            $.ajax({
                url:'/approval/get-detail-cham-cong',
                data:{
                    date: date,
                    user_id: user_id
                },
                success:function (data) {
                    if(data){
                        $('#myModal .full_name').html(`${data.full_name}, Ngày ${date}`)

                        let date_text = '';
                        let time = '';
                        if(data.cham_cong.length > 0){
                            let date_to = data.cham_cong[0].date_time_record;
                            let date_end = data.cham_cong[data.cham_cong.length-1].date_time_record;
                            date_text = `${date_to} - ${date_end}`;
                            let time1 = Date.parse(date_to);
                            let time2 = Date.parse(date_end);
                            let time_check = Date.parse(date_check);
                            let time3 = '';
                            if(time2 > time_check){ //nếu chấm lần 2 vào ca chiều thì trừ đi 1.5 giờ
                                time3 = (time2-time1)/1000 - 5400;
                            } else {
                                time3 = (time2-time1)/1000;
                            }
                            let gio = Math.floor(time3/3600);
                            let phut = Math.floor((time3%3600)/60);
                            time = `${gio} giờ ${phut} phút`;
                        }
                        let department = data.department ? data.department.name : '';
                        $('.cong').html(cong);
                        $('.cong-an').html(cong_an);
                        $('.ma-cham-cong').html(data.approval_code);
                        $('.department').html(department);
                        $('.chot-van-tay').html(date_text);
                        $('.time').html(time);


                        //Đơn từ
                        if(data.don_tu.length > 0){
                            let html = '';
                            data.don_tu.forEach(item=>{
                                let type = item.type == 0 ? 'Đơn nghỉ' : 'Đơn checkin/out';
                                let hours = array_HOURS[0][item.time_to];
                                let text = '';
                                if(item.type == 0){ //đơn nghỉ
                                    let hours_end = array_HOURS[0][item.time_end];
                                    text = `${hours} ${formatDate(item.date)} - ${hours_end} ${formatDate(item.date_end)}`
                                } else {
                                    text = `${hours} (${item.reason.name})`
                                }

                                html+= `
                                    ${type} : ${text}
                                    </br>
                                `
                            })

                            $('#myModal #nav-don-tu').html(html);
                        }
                        else {
                            $('#myModal #nav-don-tu').html('');
                        }


                        //Chốt vân tay

                        if(data.cham_cong.length > 0){
                            let html = '';
                            data.cham_cong.forEach(item=>{
                                let type = item.type == 0 ? '(máy)' : '(đơn)';
                                html+= `
                                    ${item.date_time_record} ${type}, mã máy: ${item.name_machine}
                                    </br>
                                `
                            })

                            $('#myModal #nav-cham-cong').html(html);
                        } else {
                            $('#myModal #nav-cham-cong').html('');
                        }

                    }
                }
            })

            $('#myModal').modal('show');
        })
    </script>
@endsection
