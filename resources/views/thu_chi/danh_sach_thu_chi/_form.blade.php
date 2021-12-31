@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thêm mới thu chi</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('thu-chi/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('thu-chi.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col">
                <div class="row">
                    {{--<div class="col-xs-12 col-md-6">--}}
                        {{--<div class="form-group required {{ $errors->has('danh_muc_thu_chi_id') ? 'has-error' : '' }}">--}}
                            {{--{!! Form::label('danh_muc_thu_chi_id', 'Chọn danh mục', array('class' => ' required')) !!}--}}
                            {{--{!! Form::select('danh_muc_thu_chi_id',$categories,@$doc->danh_muc_thu_chi_id, array('class' => 'form-control select2 changeDanhMuc','id'=>'changeDanhMuc', 'required' => true,'placeholder'=> 'Chọn danh mục')) !!}--}}
                            {{--<span class="help-block">{{ $errors->first('danh_muc_thu_chi_id', ':message') }}</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="col-md-6">
                        <div class="form-group required {{ $errors->has('ly_do_id') ? 'has-error' : '' }}">
                            {!! Form::label('ly_do_id', 'Chọn lý do', array('class' => ' required')) !!}
                            {!! Form::select('ly_do_id',$li_do,@$doc->ly_do_id, array('class' => 'form-control select2', 'required' => true,'placeholder'=> 'Chọn lý do thu chi')) !!}
                            {{--<select name="" id=""></select>--}}
                            <span class="help-block">{{ $errors->first('ly_do_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required {{ $errors->has('so_tien') ? 'has-error' : '' }}">
                            {!! Form::label('so_tien', 'Số tiền', array('class' => ' required')) !!}
                            {!! Form::text('so_tien',@number_format($doc->so_tien), array('class' => 'form-control price')) !!}
                            <span class="help-block">{{ $errors->first('so_tien', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required {{ $errors->has('duyet_id') ? 'has-error' : '' }}">
                            {!! Form::label('duyet_id', 'Người duyệt', array('class' => ' required')) !!}
                            {!! Form::select('duyet_id',$user_duyet,@$doc->duyet_id, array('class' => 'form-control select2', 'required' => true,'placeholder'=> 'Chọn người duyệt')) !!}
                            <span class="help-block">{{ $errors->first('duyet_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('type', 'Chọn kiểu', array('class' => ' required')) !!}
                            {!! Form::select('type',$type,@$doc->type, array('class' => 'form-control select2', 'required' => true,'placeholder'=> 'Chọn kiểu')) !!}

                            <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required {{ $errors->has('created_at') ? 'has-error' : '' }}">
                            {!! Form::label('created_at', 'Chọn ngày', array('class' => ' required')) !!}
{{--                            {!! Form::select('created_at',null,@$doc->created_at, array('class' => 'form-control select2', 'required' => true,'placeholder'=> 'Chọn người duyệt')) !!}--}}
                            {!! Form::text('created_at', @\App\Helpers\Functions::dayMonthYear($doc->created_at), array('class' => 'form-control fc-datepicker')) !!}
                            <span class="help-block">{{ $errors->first('created_at', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('note', 'Ghi chú') !!}
                            {!! Form::textarea('note', null, array('class' => 'form-control', 'rows' => 3)) !!}

                            <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bot">
                    <button type="submit" class="btn btn-success">Lưu</button>
                    <a href="{{route('thu-chi.index')}}" class="btn btn-danger">Về danh sách</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('form#fvalidate').validate({
                rules: {
                    danh_muc_thu_chi_id: 'required',
                    so_tien: 'required',
                    duyet_id: 'required',
                    type: 'required',
                },
                messages: {
                    danh_muc_thu_chi_id: "vui lòng chọn danh mục",
                    so_tien: 'vui lòng nhập số tiền',
                    duyet_id : 'vui lòng chọn người duyệt',
                    type: 'vui lòng chọn kiểu'
                }
            });
        })

        $('body').on('keyup', '.price', function (e) {
            let target = $(e.target).parent().parent();
            let price = $(target).find('.price').val();
            price = replaceNumber(price);
            $(target).find('.price').val(formatNumber(price));
        });

        // $('#changeDanhMuc').on('select2:select', function (e) {
        //     let data = e.target.value;
        //     let html = '';
        //     let row = $('#ly_do_id');
        //
        //     $.ajax({
        //         url:'/get-ly-do-thu-chi/' + data,
        //         success:function (data) {
        //             if(data){
        //                 data.forEach(item=>{
        //                     html+= `
        //                             <option value=`+item.id+`>`+item.name+`</option>
        //                         `
        //                 })
        //                 row.html(html);
        //             }
        //         }
        //     })
        // });
    </script>
@endsection
