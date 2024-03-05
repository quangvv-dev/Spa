@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
@endsection
@section('content')
    <style>
        .inputfile {
            /*width: 0.1px;*/
            /*height: 0.1px;*/
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile + label {
            cursor: pointer;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách vi phạm</h3>
                <div class="col">
                    <a class="right btn btn-primary btn-flat" href="{{ route('errors.monitoring.create') }}"><i
                            class="fa fa-plus-circle"></i> Tạo mới</a>
                </div>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('errors.monitoring.index')}}" method="get" id="gridForm">
                    <div class="col-md-3">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    <div class="col-xs-12 col-md-2">
                        {!! Form::select('position_id',$position, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn vị trí--')) !!}
                    </div>

                    <div class="col-xs-12 col-md-2">
                        {!! Form::select('block_id',$block, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn khối--')) !!}
                    </div>
                    <div class="col-xs-12 col-md-2">
                        {!! Form::select('error_id',$error, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn lỗi vi phạm--')) !!}
                    </div>

                    <input type="hidden" name="page" id="page">
                    <div class="col-xs-12 col-md-2">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                    </div>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a style="display: none" href="#" class="angleDoubleUp">
                                    <i class="fa fa-angle-double-up"></i></a></li>
                            <li><a href="#" class="angleDoubleDown"><i class="fa fa-angle-double-down"></i></a></li>
                        </ul>
                    </div>
                    @include('errors.monitoring.dropdownFilter')
                </form>
            </div>
            <div id="registration-form">
                @include('errors.monitoring.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script type="text/javascript">
        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            $('#page').val(pages);
            $('#gridForm').submit();
        });
        $(document).on('change', '.check', function () {
            let value = this.checked ? 1 : 0;
            $.ajax({
                url: "/errors/monitoring/" + $(this).data('id'),
                type: 'PUT',
                // _method:'PUT',
                data: {
                    status: value,
                }
            }).done(function (data) {
                alertify.success('Cập nhật tk thành công !');
            });
        });
    </script>
@endsection
