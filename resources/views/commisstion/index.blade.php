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
                <h3 class="card-title">{{$title}}</h3>
            </div>
            <div class="card-header">
                <span class="text-info bold">GIÁ TRỊ ĐƠN: </span> <span class="text-danger bold">&nbsp;&nbsp; {{number_format($order->all_total)}} đ</span>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('commission/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => url()->full(), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col order" style="padding: 10px">
                @if(isset($commissions) && $commissions)
                    @foreach($commissions as $item)
                        <div class="row">
                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                            <div class="col-xs-12 col-md-3">
                                {!! Form::label('user_id', 'Nhân viên hưởng', array('class' => ' required')) !!}
                                {!! Form::select('user_id[]', $users, $item->user_id, array('class' => 'form-control select2 user', 'placeholder' => 'Chọn nhân viên')) !!}
                            </div>
{{--                                <div class="col-xs-12 col-md-2">--}}
{{--                                    <div class="form-group required {{ $errors->has('earn') ? 'has-error' : '' }}">--}}
{{--                                        {!! Form::label('percent', 'Hoa hồng hưởng (%)', array('class' => ' required')) !!}--}}
{{--                                        {!! Form::number('percent[]', isset($item->percent) ? $item->percent: "", array('class' => 'form-control percent-order')) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            <div class="col-xs-12 col-md-3">
                                <div class="form-group required {{ $errors->has('earn') ? 'has-error' : '' }}">
                                    {!! Form::label('earn', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                                    {!! Form::text('earn[]', number_format($item->earn), array('class' => 'form-control earn-order')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2 hidden">
                                <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                                    {!! Form::label('all_total', 'Giá tiền', array('class' => ' required')) !!}
                                    {!! Form::text('all_total', $order->gross_revenue, array('class' => 'form-control price-total hidden','required'=>true)) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-5">
                                <div class="form-group required {{ $errors->has('note') ? 'has-error' : '' }}">
                                    {!! Form::label('note', 'Ghi chú') !!}
                                    {!! Form::text('note[]', $item->note, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-1" style="display: flex; align-items: center">
                                <a title="Xóa" class="btn delete" href="javascript:void(0)"
                                   data-url="{{ url('commission/' . $item->id . '/delete') }}"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col bot">
                <a href="javascript:void(0)" id="add_row" class="red">(+)Tạo người hưởng</a>
            </div>

            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('order.show',$order->id)}}" class="btn btn-danger">Trở lại</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        $('.number').number(true);
        $(document).on('click', '#add_row', function () {
            $('.order').append(`
            <div class='row item-file' >
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('user_id', 'Nhân viên hưởng', array('class' => ' required')) !!}
                        {!! Form::select('user_id[]', $users, null, array('class' => 'form-control select2 user', 'required' => true, 'placeholder' => 'Chọn nhân viên')) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                {{--<div class="col-xs-12 col-md-2">--}}
                {{--    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">--}}
                {{--        {!! Form::label('percent', 'Hoa hồng hưởng (%)', array('class' => ' required')) !!}--}}
                {{--        {!! Form::number('percent[]', null, array('class' => 'form-control percent-order', 'min' => 1)) !!}--}}
                {{--    </div>--}}
                {{--</div>--}}
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('earn', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                        {!! Form::text('earn[]', null, array('class' => 'form-control earn-order','required'=>true)) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-md-2 hidden">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('all_total', 'Giá tiền', array('class' => ' required')) !!}
                        {!! Form::text('all_total', $order->gross_revenue, array('class' => 'form-control price-total hidden','required'=>true)) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="form-group required {{ $errors->has('note') ? 'has-error' : '' }}">
                        {!! Form::label('note', 'Ghi chú') !!}
                        {!! Form::text('note[]', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-md-1" style="margin-top:34px">
                <a class="remove"> <i class="fa fa-times fa-2x"></i> </a>
            </div>
            </div>`);
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
                const parent = $(this).closest('.row.item-file');
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

        $(document).on('keyup', '.percent-order', function (e) {
            let target = $(e.target).parent().parent().parent();
            let percent = $(this).val();
            let price = $(target).find('.price-total').val();
            let earn = (percent / 100) * price;
            $(target).find('.earn-order').val(formatNumber(earn));
        });

        $(document).on('keyup', '.earn-order', function (e) {
            let target = $(e.target).parent().parent().parent();
            let earn = $(this).val();
            $(target).find('.earn-order').val(formatNumber(earn));
        })

    </script>
@endsection
