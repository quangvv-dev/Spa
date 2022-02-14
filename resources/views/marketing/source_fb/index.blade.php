@extends('layout.app')
@section('content')
        <!-- card actions section start -->
        <div class="card">
            {!! Form::open(array('url' => url()->current(), 'id'=> 'gridForm','role'=>'form')) !!}

            <div class="card-header fix-header bottom-card add-paginate">
                    <div class="col-12">
                        <div class="row" style="align-items: baseline">
                            <h4 class="col-2">Nguồn dữ liệu</h4>
                            <div class="col-2">
                                {!! Form::select('searchUser',$marketings, null, array('class' => 'form-control select2','data-placeholder' => 'Chọn mkt')) !!}
                            </div>
                            <div class="col-2">
                                {!! Form::select('searchCategory',$categories, null, array('class' => 'form-control select2','data-placeholder' => 'Chọn dịch vụ')) !!}
                            </div>
                            <div class="col-2">
                                {!! Form::select('searchBranch',$branch_ids, null, array('class' => 'form-control select2','data-placeholder' => 'Chọn chi nhánh')) !!}
                            </div>
                            <div class="col-2">
                                <input name="searchName" type="text" class="form-control" placeholder="Tên source">
                            </div>
                            <button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <div class="card-content collapse show">
                <div class="card-body">
                    @include('marketing.source_fb.ajax')
                    @include('marketing.source_fb.modal')
                </div>
            </div>
        </div>
        <!-- // card-actions section end -->

@endsection
@section('_script')
    <script>
        
        $(document).on('click','.searchData',function () {

        })

        $(document).on('click','.add_new',function (e) {
            e.preventDefault();
            resetValueForm();
            $('#modalSourceFB').modal('show');

        })


        $(document).on('click', '.edit', function () {
            let item = $(this).data('item');
            console.log(123123,item);
            let form = $('#validateForm');
            form.attr('action', '/marketing/source-fb/' + item.id);
            form.attr('method', 'POST');
            $('#myModalLabel').html('Cập nhật nguồn').change();
            $('#validateForm').append('<input name="_method" class="_method" type="hidden" value="PUT" />');

            $('#name').val(item.name);
            $('.category_id').val(JSON.parse(item.category_id)).change();
            $('.sale_id').val(JSON.parse(item.sale_id)).change();
            $('#modalSourceFB').modal('show');
        })

        function resetValueForm(){
            console.log(23432234423);
            let form = $('#validateForm');
            let acction = '/marketing/source-fb';
            form.attr('action', acction);
            $('._method').remove();
            $('#modalSourceFB .name').val('').change();
            $('#modalSourceFB .category_id').val('').change();
            $('#modalSourceFB .sale_id').val('').change();
        }

        $(document).on('click','.onAccept',function () {
            let value = $(this).is(':checked');
            let id = $(this).data('id');
            let data = {
                id: id,
                value: value
            };
            $.ajax({
                url:'/marketing/update-accept-source',
                method:'post',
                data:data,
                success:function (data) {
                    if(data && data.statusCode == true){
                        if(value == true){
                            alertify.success('Duyệt thành công !');
                        } else {
                            alertify.success('Hủy duyệt thành công !');
                        }
                    }else {
                        alertify.error('Đã có lỗi xảy ra !');
                    }
                }
            })
            // axios.post('/ajax/marketing/update-accept-source',
            //     data)
            //     .then(res => {
            //         if (res.data.statusCode == 200) {
            //             if(value == true){
            //                 alertify.success('Duyệt thành công !');
            //             } else {
            //                 alertify.success('Hủy duyệt thành công !');
            //             }
            //         } else {
            //             alertify.error('Bạn không có quyền !');
            //         }
            //     })
            //     .catch(err => {
            //         console.log('error', err)
            //     })
        })
    </script>
@endsection
