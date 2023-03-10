@extends('layout.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>

    <style type="text/css">
        .table-line th {
            text-align: left;
            padding: 8px;
            font-size: 11px;
            font-style: italic;
            vertical-align: bottom;
        }

        .table-line td {
            text-align: left;
            border-top: 1px solid #aaa;
            padding: 2px;
        }

        .pu-caption {
            font-size: 14px;
            font-weight: 600;
            font-family: "Roboto Condensed";
            color: #fc6d2e;
            text-transform: uppercase;
            padding: 10px 22px 6px 10px;
            border-bottom: 2px solid #ff8f5d;
            margin-bottom: 15px;
        }

        .form-control {
            display: unset;
        }

        tr.r-caption td {
            background-color: orange;
        }

        tr.r-caption-m td {
            background-color: yellowgreen;
        }

        .bxh-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .bxh .item-rank {
            width: 6.5%;
            height: 6.5%;
            display: inline-block;
            position: absolute;
        }

        .bxh .item-rank .avatar-container {
            display: inline-block;
            height: 100%;
            width: 100%;
            overflow: hidden;
            border-radius: 50%;
            border: 6px solid #e8e9ec;
        }

        .bxh .item-rank .item-info {
            text-align: center;
        }

        .bxh .item-rank .item-stt {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .bxh .item-rank .item-tennv {
            font-size: 11px;
            padding-top: 3px;
        }

        .bxh .item-rank .item-ds {
            font-size: 11px;
            padding-top: 3px;
        }

        .bxh .item-rank1 .avatar-container {
            border: 6px solid #f49000;
        }

        .bxh .item-rank.my-rank .avatar-container {
            border: 6px solid #0aa2e1;
            box-shadow: 0 0 15px #0aa2e1;
        }

        .bxh .item-rank.my-rank .item-stt {
            color: #0aa2e1;
        }

        .bxh .item-rank.my-rank .item-tennv {
            color: #0aa2e1;
            font-weight: bold;
        }

        .bxh .item-rank.my-rank .item-ds {
            color: #0aa2e1;
            font-weight: bold;
        }

        .bxh .item-rank1 .item-stt {
            color: #f48f00;
            font-size: 16px;
        }

        .bxh .item-rank1 .item-tennv {
            color: #f48f00;
            font-weight: bold;
            font-size: 12px;
        }

        .bxh .item-rank1 .item-ds {
            color: #f48f00;
            font-weight: bold;
            font-size: 12px;
        }


        .bxh .item-rank .avatar-img {
            width: 100%;
            height: auto;
            border: 1px solid white;
            border-radius: 50%;
        }

        .bxh .item-rank1 {
            right: 0%;
        }

        .bxh .item-rank2 {
            right: 9%;
            top: 2%
        }

        .bxh .item-rank3 {
            right: 18%;
            top: 4%
        }

        .bxh .item-rank4 {
            right: 27%;
            top: 6%
        }

        .bxh .item-rank5 {
            right: 36%;
            top: 8%
        }

        .bxh .item-rank6 {
            right: 45%;
            top: 10%
        }

        .bxh .item-rank7 {
            right: 54%;
            top: 12%
        }

        .bxh .item-rank8 {
            right: 63%;
            top: 14%
        }

        .bxh .item-rank9 {
            right: 72%;
            top: 16%
        }

        .bxh .item-rank10 {
            right: 81%;
            top: 18%
        }

        .bxh .item-rank11 {
            right: 94%;
            top: 21%
        }

        .bxh .king-sale {
            display: none;
            text-align: center;
            position: absolute;
            width: 100%;
            margin-top: -40%;
        }

        .bxh .king-sale img {
            width: 45%;
        }

        .bxh .item-rank1 .king-sale {
            display: block;
        }

        .square {
            position: relative;
            width: 100%;
        }

        .square:after {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .content1 {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        @keyframes blink1 {
            0% {
                box-shadow: 0 0 25px #f49000;
            }
            50% {
                box-shadow: 0 0 5px #f49000;
            }
            100% {
                box-shadow: 0 0 25px #f49000;
            }
        }

        @-webkit-keyframes blink1 {
            0% {
                box-shadow: 0 0 25px #f49000;
            }
            50% {
                box-shadow: 0 0 5px #f49000;
            }
            100% {
                box-shadow: 0 0 25px #f49000;
            }
        }

        @keyframes blink2 {
            0% {
                box-shadow: 0 0 25px #0aa2e1;
            }
            50% {
                box-shadow: 0 0 5px #0aa2e1;
            }
            100% {
                box-shadow: 0 0 25px #0aa2e1;
            }
        }

        @-webkit-keyframes blink2 {
            0% {
                box-shadow: 0 0 25px #0aa2e1;
            }
            50% {
                box-shadow: 0 0 5px #0aa2e1;
            }
            100% {
                box-shadow: 0 0 25px #0aa2e1;
            }
        }

        .blink1 {
            animation: blink1 5.0s linear infinite;
        }

        .table-responsive {
            overflow-x: inherit;
        }
        .card-content .card-body{
            height: 72vh;
            overflow: auto;
        }
        .card-content .card-body .content1{
            margin-top: 20px;
        }

    </style>
    <!-- card actions section start -->
    <div class="card">
        <form action="{{url()->current()}}" method="get" id="gridForm">
            <div class="card-header fix-header bottom-card add-paginate">
                <div class="row" style="width: 100%;">
                    <h4 class="col-lg-2">Hoa hồng</h4>
                    <div class="col-md-3">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    @if($check_admin)
                        <div class="col-lg-2 col-md-6">
                            {!! Form::select('searchUser', [1=>'Bác sĩ',2=>'Tư vấn',3=>'Lễ tân - Kỹ thuật viên'], null, array('class' => 'form-control', 'placeholder'=>'Tất cả',)) !!}
                        </div>
                    @endif
                    <button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>
                </div>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
        </form>
        <div class="card-content collapse show">
            <div class="card-body" id="registration-form">
                @include('statistics.hoa_hong_ajax')
            </div>
        </div>
    </div>
    <!-- // card-actions section end -->
    <!-- Modal -->
    <div class="modal fade" id="modalMultiPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Danh sách đơn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 55vh;overflow: auto;">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-primary">
                            <tr>
                                <td class="text-center">STT</td>
                                <td class="text-center">Số điện thoại</td>
                                <td class="text-center">Tổng tiền</td>
                                <td class="text-center">Ngày</td>
                            </tr>
                            <tbody class="listOrder">
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">3245345</td>
                                    <td class="text-center">100000</td>
                                    <td class="text-center">14/05/2022</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        $(document).on('click','.showDetail',function () {
            let user_id = $(this).data('id');
            $.ajax({
                url:`/ajax/report/detail-hoa-hong/${user_id}`,
                success:function (data) {
                    let html = '';
                    if(data && data.length > 0){
                        data.forEach((f,i)=>{
                            html += `
                                <tr>
                                    <td class="text-center">${i+1}</td>
                                    <td class="text-center">${f.order.customer.phone}</td>
                                    <td class="text-center">${formatNumber(f.price)}</td>
                                    <td class="text-center">${f.created_at}</td>
                                </tr>
                            `
                        });
                        $('#modalMultiPage .listOrder').html(html);
                    } else {
                        $('#modalMultiPage .listOrder').html('');
                    }
                }
            })
            $('#modalMultiPage').modal('show');
        })
    </script>
@endsection
