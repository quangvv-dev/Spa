@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DS Sản phẩm kho</h3></br>
                <div class="col">
                    <a title="Upload Data" class="btn" href="#"
                       data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-upload"></i></a>
                </div>
            </div>
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}

            <div class="card-header" style="align-items: flex-end">
                @if(empty($checkRole))
                    <div class="col-md-2" style="font-size: 16px;">
                        {!! Form::select('branch_id', $deposts, null, array('class' => 'form-control branch_id','placeholder'=>'--Chi nhánh--')) !!}
                    </div>
                @endif
                <div class="col-md-3" style="font-size: 16px;">
                    {!! Form::select('product_id', $products, null, array('class' => 'form-control select2 product_id','placeholder'=>'--Chọn sản phẩm--')) !!}
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
            </div>

            {{ Form::close() }}

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
