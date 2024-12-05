@extends('layout.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <div class="content-body" style="width: 100%">
        <section id="card-actions">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
                        <div class="card-header fix-header bottom-card add-paginate">
                            <div class="row">
                                <h4 class="col-lg-12">6.4 Lịch sử nhập, xuất kho</h4>
                            </div>
                        </div>
                        <div class="card-header fix-header bottom-card">
                            <div class="row" style="width: 100%">
                                <input type="hidden" name="start_date" id="start_date1">
                                <input type="hidden" name="end_date" id="end_date1">
                                <div class="col-lg-4 col-md-6">
                                    <input id="reportrange1" type="text" class="form-control square">
                                </div>
                                @if(empty($checkRole))
                                    <div class="col-lg-2 col-md-6">
                                        {!! Form::select('branch_id', $deposts, null, array('class' => 'form-control square','placeholder'=>'--Chọn kho--')) !!}
                                    </div>
                                @endif
                                <div class="col-lg-3 col-md-6">
                                    {!! Form::select('product_id', $products, null, array('class' => 'form-control square select2','data-placeholder'=>'--Chọn sản phẩm--')) !!}
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                                    </button>
                                </div>
                            </div>

                        </div>
                        {{ Form::close() }}
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('history_depot.statisticalAjax')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // card-actions section end -->
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('script')
    <!-- file upload -->
@endsection
