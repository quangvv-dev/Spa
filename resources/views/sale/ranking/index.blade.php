@extends('layout.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>

    <style>
        .container .ranking .item {
            height: 80px;
            background-repeat: no-repeat !important;
            background-size: 100% 80px !important;
        }
        .item .header1_bg {

        }
        .item .header1_ava {
            top: 33px;
            left: 37px;
            position: absolute;
            transform: translate(-50%, -50%) rotate(0deg);
            width: 72px;
            height: 72px;
            clip-path: polygon(25% 6.7%, 75% 6.7%, 100% 50%, 75% 93.3%, 25% 93.3%, 0% 50%);
            z-index: 1;
        }

        .item.top1 {
            background: url({{asset('layout/images/bg_ranking1.png')}});
        }

        .item.top2 {
            background: url({{asset('layout/images/bg_ranking2.png')}});
        }

        .item.top3 {
            background: url({{asset('layout/images/bg_ranking3.png')}});
        }

        .item.top4 {
            background: url({{asset('layout/images/bg_ranking.png')}});
        }


        .daterange-custom {
            background: #131313;
            border: 1px solid #686777;
            color: #fff;
            padding: 13.5px 16px;
            outline: none;
            border-radius: 8px;
        }
        .marketing .box{
            width: 263px;
            /* height: 288px; */
            box-shadow: 0px 0px 16px 0px #FFFFFF17;
            border: 1px solid #686777;
            border-radius: 16px;
        }
        .marketing .box .header1 {
            height: 112px;
            background: linear-gradient(84.27deg, #F5FAFD -5.36%, #DBEAAC 39.03%, #FDF7AF 75.21%, #FFFFF7 97.86%);
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            z-index: 1;
        }
        .marketing .box .body {
            background: #131313;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }
        .marketing .box .header1 img{
            position: absolute;
            right: 16px;
            top: 16px;
        }
        .marketing .box .header1 .header1_bg{
            position: absolute;
            left: 16px;
            top: 78px;
        }
        .marketing .box .header1 .header1_ava{
            top: 111px;
            position: absolute;
            transform: translate(-50%, -50%) rotate(0deg);
            width: 72px;
            height: 72px;
            clip-path: polygon(25% 6.7%, 75% 6.7%, 100% 50%, 75% 93.3%, 25% 93.3%, 0% 50%);
            z-index: 1;
            left: 53px;
        }
        .marketing .top1 .box .header1 {
            background: linear-gradient(84.27deg, #F5FAFD -5.36%, #DBEAAC 39.03%, #FDF7AF 75.21%, #FFFFF7 97.86%);
        }
        .marketing .top2 .box .header1 {
            background: linear-gradient(87.17deg, #FFF5FE 0.78%, #A1EAEB 34.54%, #BADFEF 61.95%, #F3FFFD 95.89%);
        }
        .marketing .top3 .box .header1 {
            background: linear-gradient(84.27deg, #F1FFF0 -5.36%, #D9E9B5 39.03%, #F9DABE 75.21%, #FFFFF7 97.86%);
        }
        .marketing .content {
            padding-left: 0;
        }
        .rank {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        body{
            color: white;
        }
        /* .rank .top1 .header1 */
    </style>
        <!-- card actions section start -->
        <div class="card">
            <form action="{{url()->current()}}" method="get" id="gridForm">
                <div class="card-header fix-header bottom-card add-paginate">
                    <div class="row" style="width: 100%;">
                        <div class="fs-28 font-sopher">Bảng xếp hạng</div>
                        <div class="col-md-3">
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input id="reportrange" type="text" class="form-control square">
                        </div>
                        @if(auth()->user()->permission('filter.team'))
                            <div class="col-lg-2 col-md-3">
                                {!! Form::select('team_id', $teams, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Chọn team')) !!}
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
                    @include('sale.ranking.ajax')
                </div>
            </div>
        </div>
        <!-- // card-actions section end -->

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script>

    </script>
@endsection
