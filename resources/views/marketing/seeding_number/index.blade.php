@extends('layout.app')
@section('content')
    <div class="card">


        {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
        <div class="card-header fix-header bottom-card add-paginate">
            <div class="row" style="align-items: baseline">
                <h4 class="col-lg-3">2.9 Kho số seeding</h4>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input name="searchPhone" type="text" class="form-control square" placeholder="Tìm kiếm ...">
                    </div>
                </div>
                <button class="btn btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        {{ Form::close() }}


        <div class="card-header fix-header">
            <button class="btn btn-primary btnAddNew" data-toggle="modal" data-target="#add_new"><i
                        class="fa fa-plus"></i> Thêm số seeding
            </button>
            <button class="btn btn-warning btnDelete"><i class="fa fa-trash"></i> Xóa nhiều</button>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                @include('marketing.seeding_number.ajax')
            </div>
        </div>
    </div>

    </section>
    <!-- // card-actions section end -->
    <div class="modal fade text-left" id="add_new" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel35"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-main">
                    <h5 class="modal-title" id="myModalLabel35"> Cập nhật số seeding</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @include('marketing.seeding_number._form')
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('click', '.btnDelete', function () {
            let favorite = [];
            $.each($("input[getData]:checked"), function () {
                favorite.push($(this).val());
            });

            swal({
                title: 'Bạn chắc chắn muốn xóa?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                showCloseButton: true,
            }).then(function () {
                $.ajax({
                    url: '/ajax/delete-seeding',
                    method: 'delete',
                    data: {
                        data_delete: favorite
                    },
                    success: function (data) {
                        if (data) {
                            alertify.success('Xóa thành công !');
                            setTimeout(function () {
                                window.location.reload()
                            }, 500)
                        } else {
                            alertify.error('Có lỗi xảy ra !');
                        }
                    }
                });
            })


        })

        $(document).ready(function () {
            $(document).on('click', '.btnAdd', function () {
                console.log(234234234);
                $('#myFormId').submit();
            })
        })


    </script>
@endsection
