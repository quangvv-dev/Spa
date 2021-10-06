@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DS Sản phẩm kho</h3></br>
                <div class="col">
                    <a title="Upload Data" class="btn"  href="#"
                       data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-upload"></i></a>
                </div>
            </div>
            <form>
                <div class="card-header" style="align-items: flex-end">
                    <input class="form-control header-search col-2" name="search" placeholder="Tìm kiếm…" tabindex="1" type="search">
                    <div class="col-md-2" style="font-size: 16px;">
                        {!! Form::select('branch_id', $deposts, null, array('class' => 'form-control branch_id','placeholder'=>'--Chi nhánh--')) !!}
                    </div>
                    <div class="col-md-2" style="font-size: 16px;">
                        {!! Form::select('product_id', $products, null, array('class' => 'form-control select2 product_id','placeholder'=>'--Chọn sản phẩm--')) !!}
                    </div>
                </div>
            </form>
            <div class="header-search">
                @include('product_depot.ajax')
                @include('product_depot.modal')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')

    <script type="text/javascript">
        $('body').delegate('#add_new', 'click', function () {
            let depost = $('.branch_id').val();
            let product = $('.product_id').val();
            $.ajax({
                type: "post",
                url: '{{route('depots.product.store')}}',
                data: {branch_id: depost, product_id: product},
                success: function (data) {
                    location.reload();
                }
            });
        })
    </script>
@endsection
