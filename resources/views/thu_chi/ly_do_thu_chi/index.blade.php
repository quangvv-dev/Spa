@extends('layout.app')
@section('content')
    <style>
        .txt-dotted {
            border: 1px solid transparent;
            border-bottom: dotted 1px #999;
            width: 100%;
            padding: 0px;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lý do thu chi</h3></br>
            </div>
            <div id="registration-form">
                @include('thu_chi.ly_do_thu_chi.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">

        $(document).on('click','#add_new_cate',function () {
            $.ajax({
                url:'/ly-do-thu-chi',
                method:'post',
                data:{
                    name:name
                },
                success: function (data) {
                    location.reload();
                }
            })
        })

        $(document).on('click','.save-cate',function () {
            let id = $(this).data('id');
            let category_id = $('.category_id').val();
            if(!category_id){
                alertify.warning('vui lòng chọn danh mục !');
                return;
            }
            let name = $(this).closest('tr').find('.name').val();
            $.ajax({
                url:'/ly-do-thu-chi/'+id,
                method:'PUT',
                data:{
                    name:name,
                    category_id:category_id
                },
                success: function (data) {
                    location.reload();
                }
            })

        })

    </script>
@endsection
