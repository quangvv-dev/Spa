@extends('backend.layouts.master')
@section('content')
    <div class="content-body">
        <section id="card-actions">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
                        <div class="card-header fix-header bottom-card add-paginate">
                            <div class="row" style="align-items: baseline">
                                <h4 class="col-lg-3">6.4 Lịch sử nhập, xuất kho</h4>
                                <div class="col-lg-3 col-md-6">
                                    <input name="code_order" type="text" class="form-control square" placeholder="Mã đơn">
                                </div>
                                <button type="submit" class="btn btn-primary searchData" id="btnSearch"><i class="fa fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0"><li><a data-action="expand"><i class="ft-maximize"></i></a></li></ul>
                            </div>
                        </div>
                        <div class="card-header fix-header bottom-card">
                            <div class="row">
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">
                                <div class="col-lg-3 col-md-6">
                                    <input name="name" id="reportrange" type="text" class="form-control square" >
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    {!! Form::select('depot_id', $deposts, null, array('class' => 'form-control square','placeholder'=>'--Chọn kho--')) !!}
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    {!! Form::select('status', $status, null, array('class' => 'form-control square','placeholder'=>'--Nghiệp vụ kho--')) !!}
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    {!! Form::select('product_id', $products, null, array('class' => 'form-control square select2','data-placeholder'=>'--Chọn sản phẩm--')) !!}
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#import"><i
                                                class="fa fa-file-excel-o"></i> Import lịch sử
                                    </button>
                                </div>
                            </div>

                        </div>
                        {{ Form::close() }}
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('backend.history_depot.ajax')
                                @include('backend.history_depot._form')
                                {{--@include('backend.history_depot.import')--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // card-actions section end -->
    </div>

@endsection
@section('script')
    @include('backend.layouts.script')
    <!-- file upload -->
    <script src="/js/file_upload.js"></script>

    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/daterangepicker.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <script type="text/javascript" src="{{asset('js/dateranger-config.js')}}"></script>
    <script>

        $('#depot_id').change(function () {
            $('.list-product').html('');
            let html = '';
            $.ajax({
                url:'/ajax/product-deport/' + $(this).val(),
                success:function (data) {
                    html = '<option value="">--Chọn sản phẩm--</option>';
                    let product_id = $(document).find('.products')
                    if(data.product.length > 0){
                        data.product.forEach(function (item) {
                            html += `
                                <option value="`+item.product_id+`">`+item.product.name+`</option>
                            `
                        })

                    } else {
                        html = '';
                    }
                    product_id.html(html)
                }

            })
        })

        $('#product_id').change(function () {
            let id = $(this).val();
            if (!id) return false;
            var text = $(this).find(":selected").text();
            var html = `<tr>
                <input type="hidden" name="product[]" value="` + id + `">
                <td><span id="">` + text + `</span></td>
                <td style="width: 20%;">
                    <input type="text" maxlength="5" class="form-control text-center txt-dotted"style="height: 23px !important;" name="quantity[]">
                </td>
            </tr>`;
            $('.list-product').append(html);
        })

        $().ready(function () {
            $("#validateForm").validate({
                rules: {
                    depot_id: 'required',
                    status: 'required',
                    note: 'required',
                    // product_id: 'required',
                },
                messages: {
                    depot_id: "Vui lòng chọn kho !",
                    status: "Vui lòng chọn nghiệp vụ !",
                    note: "Vui lòng nhập ghi chú !"
                    // code: "Vui lòng nhập mã !"
                }
            })
        });

    </script>
@endsection
