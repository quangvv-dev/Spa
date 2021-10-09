@extends('layout.app')
@section('content')
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
                                <div class="col-lg-2 col-md-6">
                                    {!! Form::select('branch_id', $deposts, null, array('class' => 'form-control square','placeholder'=>'--Chọn kho--')) !!}
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    {!! Form::select('status', $status, null, array('class' => 'form-control square','placeholder'=>'--Nghiệp vụ kho--')) !!}
                                </div>
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
                                @include('history_depot.ajax')
                                @include('history_depot._form')
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
    {{--@include('backend.layouts.script')--}}
    <!-- file upload -->
    <script>

        // $("#gridForm").submit(function (e, page) {
        //     console.log('aaaa');
        //
        //     $.get($(this).attr('action'), $(this).serialize(), function (data) {
        //         console.log(data,'aaaa');
        //         $('.table-responsive').html(data);
        //     })
        // })

        $('#depot_id').change(function () {
            $('.list-product').html('');
            let html = '';
            $.ajax({
                url:'/ajax/product-depot/' + $(this).val(),
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
        $(document).on('change', '.type, .name', function () {
            $('#gridForm').submit();
        });
    </script>
@endsection
