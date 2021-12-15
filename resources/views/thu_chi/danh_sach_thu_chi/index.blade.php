@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            {!! Form::open(array('url' => url()->current(), 'id'=> 'gridForm','role'=>'form')) !!}

            <div class="card-header">
                <h3 class="card-title">Danh sách thu chi</h3></br>

                <div class="col">
                    @if(\Request::is('products'))
                        <a title="Download Data" style="position: absolute;right: 16%" class="btn"
                           href="{{route('product.export')}}">
                            <i class="fas fa-download"></i></a>
                        <a title="Upload Data" class="btn" style="position: absolute;right: 13%" href="#"
                           data-toggle="modal" data-target="#myModalImport">
                            <i class="fas fa-upload"></i></a>
                    @endif

                    <a class="right btn btn-primary btn-flat" href="{{request()->url().'/create' }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a>
                </div>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <a style="display: none" href="#" class="angleDoubleUp">
                                <i class="fa fa-angle-double-up"></i></a>
                        </li>
                        <li>
                            <a href="#" class="angleDoubleDown"><i class="fa fa-angle-double-down"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-header" style="align-items: flex-end">
                <div class="row" style="width: 100%">
                    <div class="col-3">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                        <input id="reportrange" type="text" class="form-control square">
                    </div>
                    <div class="col-2">
                        {!! Form::select('category_id', $categories, null, array('class' => 'form-control select2','id'=>'category','placeholder'=>'Chọn danh mục')) !!}
                    </div>
                    <div class="col-2">
                        <select name="status" id="status" class="form-control">
                            <option value="">Chọn trạng thái</option>
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                        </select>
                    </div>


                    <div class="col-2">
                        {!! Form::select('branch_id', $branches, null, array('class' => 'form-control select2','id'=>'branch','placeholder'=>'Chọn chi nhánh')) !!}
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>
                </div>
            </div>
            @include('thu_chi.danh_sach_thu_chi.dropdownFilter')
            </form>
            <div class="header-search">
                @include('thu_chi.danh_sach_thu_chi.ajax')
            </div>
        </div>
    </div>

    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    <script>
        $(document).on('click', '.change_status', function () {
            let status = $(this).is(':checked');
            let id = $(this).data('id');
            $.ajax({
                url: '/ajax/change-status-thu-chi',
                method: 'post',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data && data == 1) {
                        location.reload();
                    } else {
                        alert('bạn không có quyền !');
                    }
                }
            })
        })


    </script>
@endsection
