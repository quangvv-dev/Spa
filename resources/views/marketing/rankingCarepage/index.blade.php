@extends('layout.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('layout/css/ranking.css')}}"/>
        <!-- card actions section start -->
        <div class="card">
            <form action="{{url()->current()}}" method="get" id="gridForm">
                <div class="card-header fix-header bottom-card add-paginate">
                    <div class="row" style="width: 100%;">
                        <h4 class="col-lg-2 linear-text fs-24">Bảng xếp hạng</h4>
                        <div class="col-md-3">
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input id="reportrange" type="text" class="form-control square">
                        </div>
{{--                        <div class="col-lg-2 col-md-6">--}}
{{--                            {!! Form::select('is_upsale', [0=>'Khách hàng mới',1=>'Khách hàng cũ'], null, array('class' => 'form-control', 'placeholder'=>'Tất cả khách hàng',)) !!}--}}
{{--                        </div>--}}

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
                    @include('marketing.ranking.ajax')
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
