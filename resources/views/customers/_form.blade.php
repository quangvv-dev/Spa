@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <style>
        strong.select2-results__group {
            font-weight: 600;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($customer))
                {!! Form::model($customer, array('url' => url('customers/'.$customer->id), 'method' => 'put', 'files'=> true, 'id'=>'fvalidate','autocomplete'=>'off')) !!}
            @else
                {!! Form::open(array('url' => route('customers.store'), 'method' => 'post', 'files'=> true, 'id'=>'fvalidate','autocomplete'=>'off')) !!}
            @endif
            <div class="row col-md-12">
                <div class="col-md-6">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                            {!! Form::label('full_name', 'Tên KH', array('class' => 'control-label')) !!}
                            {!! Form::text('full_name', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                            {!! Form::label('phone', 'Số điện thoại', array('class' => 'control-label')) !!}
                            {!! Form::text('phone', null, array('id' => 'phone','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                        </div>
                    </div>

                    @if (isset($customer))
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('membership') ? 'has-error' : '' }}">
                                {!! Form::label('membership', 'Mã thành viên (MEMBERSHIP)') !!}
                                {!! Form::text('membership', null, array('id' => 'membership','maxLength'=>9,'class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('membership', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                {!! Form::label('fb_name', 'Tên Facebook') !!}
                                {!! Form::text('fb_name', null, array('id' => 'fb_name','class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('fb_name', ':message') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                            {!! Form::label('birthday', 'Ngày sinh') !!}
                            <div class="wd-200 mg-b-30">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    {!! Form::text('birthday', null, array('class' => 'form-control fc-datepicker')) !!}
                                </div>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('birthday', ':message') }}</span>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!! Form::label('description', 'Mô tả') !!}
                            {!! Form::text('description', null, array('id' => 'description','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('gender') ? 'has-error' : '' }}">
                            {!! Form::label('gender', 'Giới tính', array('class' => 'control-label')) !!}
                            {!! Form::select('gender',[0 => 'Nữ', 1 => 'Nam'], null, array('class' => 'form-control select2', 'placeholder' => 'Chọn giới tính')) !!}
                            <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('genitive_id') ? 'has-error' : '' }}">
                            {!! Form::label('genitive_id', 'Nhóm tính cách') !!}
                            {!! Form::select('genitive_id',$genitives, null, array('class' => 'form-control select2', 'placeholder' => 'Chọn nhóm tính cách')) !!}
                            <span class="help-block">{{ $errors->first('genitive_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('telesales_id') ? 'has-error' : '' }}">
                            {!! Form::label('telesales_id', 'Người phụ trách', array('class' => 'control-label required')) !!}
                            {{--                            {!! Form::select('telesales_id', $telesales,@$customer->telesales_id, array('class' => 'form-control select2', 'placeholder' => 'Chọn nhân viên')) !!}--}}
                            <select name="telesales_id" id="telesales_id" class="form-control select2"
                                    {{\Illuminate\Support\Facades\Auth::user()->role==\App\Constants\UserConstant::TELESALES && isset($customer) ?'disabled':''}}
                                    data-placeholder="Chọn nhân viên">
                                <option value=""></option>
                                @foreach($telesales as $k => $l)
                                    <optgroup label="{{ $k }}">
                                        @foreach($l as $kl => $vl)
                                            <option
                                                {{@$customer->telesales_id == $vl||\Illuminate\Support\Facades\Auth::user()->role==\App\Constants\UserConstant::WAITER&&\Illuminate\Support\Facades\Auth::user()->id==$vl?'selected':''}} value="{{ $vl }}">{{ $kl }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            <span class="help-block">{{ $errors->first('telesales_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
                            {!! Form::label('status_id', 'Trạng thái', array('class' => 'control-label')) !!}
                            {!! Form::select('status_id', $status, @$customer->status_id, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('facebook') ? 'has-error' : '' }}">
                            {!! Form::label('facebook', 'Link Facebook') !!}
                            {!! Form::text('facebook', null, array('id' => 'facebook','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('group_id') ? 'has-error' : '' }}">
                            {!! Form::label('group_id', 'Nhóm khách hàng', array('class' => 'required control-label')) !!}
                            @if(isset($customer))
                                <select class="form-control select2" name="group_id[]" multiple="multiple"
                                        data-placeholder="Chọn nhóm khách hàng">
                                    @foreach($categories as $item)
                                        <option
                                            value="{{ $item->id }}" {{ isset($customer) && in_array($item->id, $categoryId) ? 'selected' : "" }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                {!! Form::select('group_id[]', $group, null, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder'=> "Chọn nhóm khách hàng" )) !!}
                                <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('source_id') ? 'has-error' : '' }}">
                            {!! Form::label('source_id', 'Nguồn khách hàng', array('class' => 'required control-label')) !!}
                            {!! Form::select('source_id', $source, @$customer->source_id, array('class' => 'form-control select2', 'placeholder' => 'Nguồn khách hàng')) !!}
                            <span class="help-block">{{ $errors->first('source_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                            {!! Form::label('avatar', 'Ảnh đại diện') !!}
                            <div class="fileupload fileupload-{{isset($customer) ? 'exists' : 'new' }}"
                                 data-provides="fileupload">
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px">
                                    @if (isset($customer))
                                        <img src="{{ $customer->avatar }}" alt="image"/>
                                    @endif
                                </div>
                                <div>
                                    <button type="button" class="btn btn-default btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                                        <input type="file" name="image" accept="image/*" class="btn-default upload"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('customers.index')}}" class="btn btn-danger">Trở lại</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script>
        $(document).ready(function () {
            // validate phone
            jQuery.validator.addMethod("phone_number", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length > 9 &&
                    phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/);
            }, "Số điện thoại không hợp lệ");

            $("#fvalidate").validate({
                rules: {
                    full_name: {
                        required: true,
                        normalizer: function (value) {
                            return $.trim(value);
                        }
                    },
                    phone: {
                        required: true,
                        remote: {
                            url: "{{ url('api/check-unique-customers') }}",
                            type: "post",
                            data: {
                                phone: function () {
                                    return $("#phone").val();
                                },
                                id: {{ isset($customer) ? $customer->id : 0 }},
                            },
                        }
                    },
                    gender: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                    status_id: {
                        required: true
                    },
                    'group_id[]': {
                        required: true
                    },
                    source_id: {
                        required: true
                    },
                    telesales_id: {
                        required: true
                    }
                },
                messages: {
                    full_name: "Chưa nhập tên",
                    phone: {
                        required: "Chưa nhập số điện thoại",
                        remote: "Số điện thoại đã tồn tại trong hệ thống",
                    },
                    gender: "Chưa chọn giới tính",
                    status_id: "Chưa chọn trạng thái",
                    'group_id[]': "Chưa chọn nhóm khách hàng",
                    source_id: "Chưa chọn nguồn khách hàng",
                    telesales_id: "Chưa chọn người phụ trách",
                },
            });
        });
    </script>
@endsection
