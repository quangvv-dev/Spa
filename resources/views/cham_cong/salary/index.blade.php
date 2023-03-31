@extends('layout.app')
@section('content')
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
                            <th>Đi muộn</th>
                            <th>về sớm</th>
                        </tr>

                        </thead>
                        <tbody>
                        @forelse($docs as $item)
                            <tr data-id="{{$item->id}}">
                                <td class="text-center">1</td>
                                <td class="text-center">{{$item->full_name}}</td>
                                {{--                <td class="text-center">{{$item->full_name}}</td>--}}
                                <td class="text-center">{{@$item->department->name}}</td>
                                <td class="text-center"></td>
                                @for($i = 1; $i<= $end; $i++)
                                    <td class="text-center pointer showModal" data-date="{{$i}}">{{$item->approval[$i]}}</td>
                                @endfor
                                <td>{{array_sum($item->late)}}</td>
                                <td>2</td>
                                <th>{{array_sum($item->approval)}}</th>
                                {{--<td>123</td>--}}
                            </tr>
                        @empty
                            <td></td>
                        @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
            <!-- table-responsive -->
        </div>
    </div>
    @include('cham_cong.statistic.modal')
@endsection
@section('_script')
    <script>
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
