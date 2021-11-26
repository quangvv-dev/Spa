@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
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
            </div>
            <form>
                <div class="card-header" style="align-items: flex-end">
                    <div class="col-2">
                        {!! Form::select('', $categories, null, array('class' => 'form-control select2','id'=>'category','placeholder'=>'Chọn danh mục')) !!}
                    </div>
                    <div class="col-2">
                        <select name="status" id="status" class="form-control">
                            <option value="">Tất cả</option>
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                        </select>
                    </div>

                    <div class="col-2">
                        {!! Form::select('', $branches, null, array('class' => 'form-control select2','id'=>'branch','placeholder'=>'Chọn chi nhánh')) !!}
                    </div>
                </div>
            </form>
            <div class="header-search">
                @include('thu_chi.danh_sach_thu_chi.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>
        var cate = null;
        var branch = null;

        $(document).on('select2:select', '#category', function (e) {
            let data = e.target.value;
            cate = e.target.value;
            let status = $('#status').val();
            let branch_id = branch;
            $.ajax({
                url: '/thu-chi',
                data: {
                    category_id: data,
                    status: status,
                    branch_id: branch_id
                },
                success: function (data) {
                    console.log(data);
                    $('.table-responsive').html(data);
                }
            })
        })
        $(document).on('select2:select', '#branch', function (e) {
            let branch_id = e.target.value;
            branch = e.target.value;
            let status = $('#status').val();
            let category_id = cate;

            $.ajax({
                url: '/thu-chi',
                data: {
                    category_id: category_id,
                    status: status,
                    branch_id:branch_id

                },
                success: function (data) {
                    $('.table-responsive').html(data);
                }
            })
        })

        $(document).on('change', '#status', function (e) {
            let data = e.target.value;
            let category_id = cate;
            let branch_id = branch;
            $.ajax({
                url: '/thu-chi',
                data: {
                    status: data,
                    category_id: category_id,
                    branch_id: branch_id
                },
                success: function (data) {
                    console.log(data);
                    $('.table-responsive').html(data);
                }
            })
        })


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
