@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('category/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('category.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('full_name', 'Tên khách hàng', array('class' => ' required')) !!}
                        {!! Form::text('full_name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                        {!! Form::text('phone',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'Địa chỉ', array('class' => ' required')) !!}
                        {!! Form::text('address',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-primary">
                        <thead style="width: 100%" class="bg-primary text-white">
                        <tr>
                            <th class="text-white text-center">Dịch vụ</th>
                            <th class="text-white text-center">Số lượng</th>
                            <th class="text-white text-center">Đơn giá</th>
                            <th class="text-white text-center">VAT (%)</th>
                            <th class="text-white text-center">CK (%)</th>
                            <th class="text-white text-center">CK (đ)</th>
                            <th class="text-white text-center">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th width="250" scope="row">
                                {!! Form::select('service_id',$service,isset($doc) ?$doc->servicce_id:'' ,array('class' => 'select2 form-control service', 'required' => true)) !!}
                            </th>
                            <td class="text-center">
                                {!! Form::text('quantity',1, array('class' => 'form-control quantity', 'required' => true)) !!}
                            </td>
                            <td class="text-center">
                                {!! Form::text('price',null, array('class' => 'form-control price', 'required' => true)) !!}
                            </td>
                            <td class="text-center">
                                {!! Form::text('VAT',0, array('class' => 'form-control VAT')) !!}
                            </td>
                            <td class="text-center">
                                {!! Form::text('CK1',0, array('class' => 'form-control CK1')) !!}
                            </td>
                            <td class="text-center">
                                {!! Form::text('CK2',0, array('class' => 'form-control CK2')) !!}
                            </td>
                            <td class="text-center">
                                {!! Form::text('total_price',null, array('class' => 'form-control total','readonly'=>true)) !!}
                            </td>
                            <td class="text-center"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col bot">
                        <a href="javascript:void(0)" id="add_row" class="red">(+) Thêm sản phẩm</a>
                    </div>
                </div>

            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('category.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        // document.getElementById('myForm').onsubmit = function () {
        //     var valInDecimals = document.getElementsByClassName('VAT').value * 100;
        // }
        $('.service').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('ajax/info-service') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                $('.price').val(data['price_sell']);
                $('.total').val(data['price_sell']);
                $('.price,.VAT,.CK1,CK2,.quantity').change(function () {
                    var price = $('.price').val();
                    var quantity = $('.quantity').val();
                    var VAT = $('.VAT').val();
                    var CK1 = $('.CK1').val();
                    var CK2 = $('.CK2').val();
                    if (CK1>0) {
                        var CK2 = $('.CK2').val(0)
                    }
                    if (CK2>0) {
                        var CK1 = $('.CK1').val(0)
                    }
                    console.log(price, quantity, VAT, CK1, CK2);
                    var total_service = price * quantity + price * quantity * (VAT / 100) - price * quantity * (CK1 / 100) - CK2;
                    console.log(total_service);
                    $('.total').val(total_service);

                })

            });
        })
    </script>
@endsection
