@extends('layout.app')
@php
    $checkRole = checkRoleAlready();
    $roleGlobal = auth()->user()?:[];
@endphp
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
                <h3 class="card-title">{{$title}} {{isset($customer) ? '('.$customer->account_code.')':''}}</h3>
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
                        <div class="phone-group form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                            {!! Form::label('phone', 'Số điện thoại', array('class' => 'control-label')) !!}
                            {!! Form::text('phone', isset($customer)? auth()->user()->permission('phone.open')? $customer->phone :@str_limit($customer->phone,7,'xxx'):null, array('id' => 'phone','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                        </div>
                    </div>

{{--                    @if (isset($customer))--}}
{{--                        <div class="col-xs-12 col-md-12">--}}
{{--                            <div class="form-group required {{ $errors->has('membership') ? 'has-error' : '' }}">--}}
{{--                                {!! Form::label('membership', 'Mã thành viên (MEMBERSHIP)') !!}--}}
{{--                                {!! Form::text('membership', null, array('id' => 'membership','maxLength'=>9,'class' => 'form-control')) !!}--}}
{{--                                <span class="help-block">{{ $errors->first('membership', ':message') }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-xs-12 col-md-12">--}}
{{--                            <div class="form-group required {{ $errors->has('fb_name') ? 'has-error' : '' }}">--}}
{{--                                {!! Form::label('fb_name', 'Nghề nghiêp') !!}--}}
{{--                                {!! Form::text('fb_name', null, array('id' => 'fb_name','class' => 'form-control')) !!}--}}
{{--                                <span class="help-block">{{ $errors->first('fb_name', ':message') }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('numerology') ? 'has-error' : '' }}">
                                {!! Form::label('numerology', 'Thần số học') !!}
                                {!! Form::text('numerology', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('numerology', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('death') ? 'has-error' : '' }}">
                                {!! Form::label('death', 'Tử huyệt') !!}
                                {!! Form::text('death', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('death', ':message') }}</span>
                            </div>
                        </div>

{{--                    @endif--}}
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('job') ? 'has-error' : '' }}">
                            {!! Form::label('job', 'Nghề nghiệp') !!}
                            {!! Form::text('job', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('job', ':message') }}</span>
                        </div>
                    </div>
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
                        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                            {!! Form::label('address', 'Địa chỉ') !!}
                            {!! Form::text('address', null, array('id' => 'address','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('social_link') ? 'has-error' : '' }}">
                            {!! Form::label('social_link', 'Facebook') !!}
                            {!! Form::text('social_link', null, array('id' => 'social_link','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('social_link', ':message') }}</span>
                        </div>
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
                    @if(empty($checkRole))
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('genitive_id') ? 'has-error' : '' }}">
                                {!! Form::label('branch_id', 'Chi nhánh',['class'=>'required']) !!}
                                {!! Form::select('branch_id',$branchs, null, array('class' => 'form-control select2 branch', 'placeholder' => 'Tất cả chi nhánh')) !!}
                                <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="branch_id" value="{{$checkRole}}">
                    @endif
{{--                    <div class="col-xs-12 col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="ctv" style="width: 100%;cursor: pointer;">Cộng tác viên</label>--}}
{{--                            <input id="ctv" type="checkbox" name="type_ctv"--}}
{{--                                   style="width: 30px;height: 25px;cursor: pointer;">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="col-md-6">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('telesales_id') ? 'has-error' : '' }}">
                            {!! Form::label('telesales_id', 'Người phụ trách', array('class' => 'control-label required')) !!}
                            <select name="telesales_id" id="telesales_id" class="form-control select2"
                                    {{\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\DepartmentConstant::TELESALES && isset($customer) ?'disabled':''}}
                                    data-placeholder="Chọn nhân viên">
                                <option value=""></option>
                                @foreach($telesales as $k => $l)
                                    <optgroup label="{{ $k }}">
                                        @foreach($l as $kl => $vl)
                                            <option
                                                {{@$customer->telesales_id == $vl||\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\DepartmentConstant::WAITER&&\Illuminate\Support\Facades\Auth::user()->id==$vl?'selected':''}} value="{{ $vl }}">{{ $kl }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            <span class="help-block">{{ $errors->first('telesales_id', ':message') }}</span>
                        </div>
                    </div>

                    @if(\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\DepartmentConstant::CARE_PAGE || \Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\DepartmentConstant::ADMIN)
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('mkt_id') ? 'has-error' : '' }}">
                                {!! Form::label('mkt_id', 'MKT phụ trách', array('class' => 'control-label')) !!}
                                <select name="mkt_id" id="mkt_id" class="form-control select2"
                                        data-placeholder="Chọn nhân viên">
                                    <option value=""></option>
                                    @foreach($marketingUsers as $k => $i)
                                        <option
                                            {{@$customer->mkt_id == $k?'selected':''}} value="{{ $k }}">{{ $i }}</option>
                                    @endforeach
                                </select>

                                <span class="help-block">{{ $errors->first('mkt_id', ':message') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
                            {!! Form::label('status_id', 'Trạng thái', array('class' => 'control-label')) !!}
                            {!! Form::select('status_id', $status, @$customer->status_id, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
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
                        <div class="form-group required {{ $errors->has('category_tips') ? 'has-error' : '' }}">
                            {!! Form::label('category_tips', 'Nhóm d.vụ khai tác thêm') !!}
                            @if(isset($customer))
                                <select class="form-control select2" name="category_tips[]" multiple="multiple"
                                        data-placeholder="Chọn nhóm dịch vụ">
                                    @foreach($categories as $item)
                                        <option
                                            value="{{ $item->id }}" {{ isset($customer) && in_array($item->id, !empty($customer->category_tips)?@json_decode($customer->category_tips):[]) ? 'selected' : "" }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                {!! Form::select('category_tips[]', $group, null, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder'=> "Chọn nhóm khách hàng" )) !!}
                                <span class="help-block">{{ $errors->first('category_tips', ':message') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('genitive_id') ? 'has-error' : '' }}">
                            {!! Form::label('genitive_id', 'Nhóm tính cách') !!}
                            {!! Form::select('genitive_id', $genitives, @$customer->genitive_id, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('genitive_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('five_elements') ? 'has-error' : '' }}">
                            {!! Form::label('five_elements', 'Mệnh') !!}
                            {!! Form::select('five_elements', \App\Models\Customer::five_elements, @$customer->five_elements, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('five_elements', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('interest') ? 'has-error' : '' }}">
                            {!! Form::label('interest', 'Sở thích') !!}
                            {!! Form::text('interest', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('interest', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('facebook') ? 'has-error' : '' }}">
                            {!! Form::label('facebook', 'Tính cách khách hàng') !!}
                            {!! Form::text('facebook', null, array('id' => 'facebook','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
                        </div>
                    </div>
{{--                    <div class="col-xs-12 col-md-12">--}}
{{--                        <div class="form-group required {{ $errors->has('facebook') ? 'has-error' : '' }}">--}}
{{--                            {!! Form::label('is_gioithieu', 'SĐT khách giới thiệu') !!}--}}
{{--                            @if(isset($customer))--}}
{{--                                {!! Form::text('is_gioithieu',isset($customer)? (@$customer->gioithieu->phone.' ('.@$customer->gioithieu->full_name.' )'):null, array('id' => 'is_gioithieu','class' => 'form-control',$customer->is_gioithieu!=0?'readonly':'')) !!}--}}
{{--                            @else--}}
{{--                                {!! Form::text('is_gioithieu',null, array('id' => 'is_gioithieu','class' => 'form-control')) !!}--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ $errors->first('is_gioithieu', ':message') }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
                <button type="submit" class="btn btn-success" id="btn-submit-customer">Lưu</button>
                <a href="{{route('customers.index')}}" class="btn btn-danger">Trở lại</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script>
        @if (isset($customer) && !$roleGlobal->permission('customer.changeBranch') )
        $('.branch').select2({
            disabled: true
        });
        @endif

        $(document).on('keyup', '#phone',function () {
            $('#btn-submit-customer').prop('disabled', false);
            let current = $(this);
            current.closest('.phone-group').find('.help-block').html('');
            $.ajax({
                url: '/api/check-unique-customers',
                type:"post",
                data: {
                    phone: $(this).val(),
                },
                success: function (data) {
                    if(data == 'true'){
                        current.closest('.phone-group').find('.help-block').html('Số điện thoại đã tồn tại')
                        @if(setting('accept_duplicate_phone') =='off')
                            $('#btn-submit-customer').prop('disabled', true);
                        @endif
                    }
                }
            })
        });

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
                    },
                    gender: {
                        required: true
                    },
                    branch_id: {
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
                    branch_id: "Chưa chọn chi nhánh",
                    phone: {
                        required: "Chưa nhập số điện thoại",
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
