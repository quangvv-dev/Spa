@extends('layout.app')
@section('content')
    <style>
        a#remove {
            color: #fb8787;
            margin-top: 34px !important;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('commission/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => url()->full(), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col order" style="padding: 10px">
                @if(isset($doc) && $doc)
                    @foreach(\json_decode($doc->customer_id) as $k1 =>$value1)
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                {!! Form::label('customer_id', 'Nhân viên hưởng', array('class' => ' required')) !!}
                                {!! Form::select('customer_id[]', $customers, $value1, array('class' => 'form-control select2 user', 'required' => true,'disabled'=>true, 'placeholder' => 'Chọn nhân viên')) !!}
                                {!! Form::hidden('customer_id[]', $value1, array('class' => 'form-control','readonly'=>true,'required'=>true)) !!}
                            </div>
                            @foreach(\json_decode($doc->rose_price) as $k2 =>$value2)
                                @if($k1==$k2)
                                    <div class="col-xs-12 col-md-3">
                                        <div class="form-group required {{ $errors->has('rose_price') ? 'has-error' : '' }}">
                                            {!! Form::label('rose_price', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                                            {!! Form::text('rose_price[]', $value2, array('class' => 'form-control rose_price number','readonly'=>true,'required'=>true)) !!}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="form-group required {{ $errors->has('note') ? 'has-error' : '' }}">
                    {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                    {!! Form::textarea('note', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col bot">
                <a href="javascript:void(0)" id="add_row" class="red">(+)Tạo người hưởng</a>
            </div>

            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{url('list-orders')}}" class="btn btn-danger">Về danh sách đơn hàng</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        $('.number').number(true);
        $(document).on('click', '#add_row', function () {
            $('.order').append(`
            <div class='row item-file' >
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('customer_id', 'Nhân viên hưởng', array('class' => ' required')) !!}
                    {!! Form::select('customer_id[]', $customers, null, array('class' => 'form-control select2 user', 'required' => true, 'placeholder' => 'Chọn nhân viên')) !!}
                <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('rose_price', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                    {!! Form::text('rose_price[]', null, array('class' => 'form-control number','required'=>true)) !!}
                </div>
            </div>
            <div class="col-xs-12 col-md-1" style="margin-top:34px">
                <a class="remove"> <i class="fa fa-times fa-2x"></i> </a>
            </div>
       </div>
`);
            $('.number').number(true);
            $("#fvalidate").validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    rose_price: {
                        required: true
                    }
                },
                messages: {
                    customer_id: "Vui lòng chọn nhân viên hưởng",
                    rose_price: "Vui lòng nhập số tiền hưởng",
                },
            });
            $('.remove').click(function () {
                var parent = $(this).closest('.row.item-file');
                parent.remove();
            });
            $('.select2').select2({
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                placeholder: function () {
                    $(this).data('placeholder');
                }
            });

            $('.select2-hidden-accessible').on('change', function () {
                $(this).valid();
            });
        });
        $("#fvalidate").validate({
            rules: {
                customer_id: {
                    required: true
                },
                rose_price: {
                    required: true
                }
            },
            messages: {
                customer_id: "Vui lòng chọn nhân viên hưởng",
                rose_price: "Vui lòng nhập số tiền hưởng",
            },
        });

    </script>
@endsection
