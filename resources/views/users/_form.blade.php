@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($user))
                {!! Form::model($user, array('url' => url('users/'.$user->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('users.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('full_name', 'Tên người dùng', array('class' => ' required')) !!}
                        {!! Form::text('full_name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                        {!! Form::number('phone', null, array('id' => 'phone','class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email', array('class' => ' required')) !!}
                        {!! Form::email('email', null, array('id' => 'email', 'class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                        {!! Form::label('birthday', 'Ngày sinh', array('class' => ' required')) !!}
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
                @if (Auth::user()->role == \App\Constants\UserConstant::ADMIN)
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('role') ? 'has-error' : '' }}">
                            {!! Form::label('role', 'Quyền', array('class' => ' required')) !!}
                            {!! Form::select('role', [1 => 'Admin', 2 => 'Marketing', 3 => 'Telesales', 4 => 'Lễ tân', 5 => 'Kỹ thuật viên', 6 => 'Khách hàng'], null, array('class' => 'form-control select2', 'placeholder' => 'Chọn quyền')) !!}
                            <span class="help-block">{{ $errors->first('role', ':message') }}</span>
                        </div>
                    </div>
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('gender') ? 'has-error' : '' }}">
                        {!! Form::label('gender', 'Giới tính', array('class' => ' required')) !!}
                        {!! Form::select('gender',[0 => 'Nữ', 1 => 'Nam'], null, array('class' => 'form-control select2', 'placeholder' => 'Chọn giới tính')) !!}
                        <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                    </div>
                </div>
                @if(\Auth::user()->role == App\Constants\UserConstant::ADMIN)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('mkt_id') ? 'has-error' : '' }}">
                        {!! Form::label('mkt_id', 'Nhân viên MKT', array('class' => ' required')) !!}
                        {!! Form::select('mkt_id', $marketingUsers,@$user->mkt_id, array('class' => 'form-control select2', 'placeholder' => 'Chọn nhân viên marketing')) !!}
                        <span class="help-block">{{ $errors->first('mkt_id', ':message') }}</span>
                    </div>
                </div>
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('telesales_id') ? 'has-error' : '' }}">
                        {!! Form::label('telesales_id', 'Nhân viên Telesales', array('class' => ' required')) !!}
                        {!! Form::select('telesales_id', $telesales,@$user->telesales_id, array('class' => 'form-control select2', 'placeholder' => 'Chọn nhân viên telesale')) !!}
                        <span class="help-block">{{ $errors->first('telesales_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
                        {!! Form::label('status_id', 'Trạng thái', array('class' => ' required')) !!}
                        {!! Form::select('status_id', $status, @$user->status_id, array('class' => 'form-control select2', 'placeholder' => 'Mối quan hệ')) !!}
                        <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('group_id') ? 'has-error' : '' }}">
                        {!! Form::label('group_id', 'Nhóm khách hàng', array('class' => ' required')) !!}
                        {!! Form::select('group_id', $group, @$user->group_id, array('class' => 'form-control select2', 'placeholder' => 'Nhóm khách hàng')) !!}
                        <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('source_id') ? 'has-error' : '' }}">
                        {!! Form::label('source_id', 'Nguồn khách hàng', array('class' => ' required')) !!}
                        {!! Form::select('source_id', $source, @$user->source_id, array('class' => 'form-control select2', 'placeholder' => 'Nguồn khách hàng')) !!}
                        <span class="help-block">{{ $errors->first('source_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                        {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required')) !!}
                        {!! Form::select('branch_id', $branch, @$user->branch_id, array('class' => 'form-control select2', 'placeholder' => 'Chi nhánh')) !!}
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                </div>
                @if(\Auth::user()->role == App\Constants\UserConstant::ADMIN)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Mật khẩu', array('class' => ' required')) !!}
                        <input type="password" name="password" id="password" autocomplete="new-password"
                               class="form-control">
                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                        {!! Form::label('confirm_password', 'Nhập lại mật khẩu', array('class' => ' required')) !!}
                        <input type="password" name="confirm_password" autocomplete="new-password" class="form-control">
                        <span class="help-block">{{ $errors->first('confirm_password', ':message') }}</span>
                    </div>
                </div>
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        {!! Form::label('avatar', 'Ảnh đại diện', array('class' => ' required')) !!}
                        <div class="fileupload fileupload-{{isset($user) ? 'exists' : 'new' }}"
                             data-provides="fileupload">
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px">
                                @if (isset($user))
                                    <img src="{{ $user->avatar }}" alt="image"/>
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
            <div class="col" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('users.index')}}" class="btn btn-danger">Trở lại</a>
            </div>

            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <!-- Bootstrap fileupload js -->
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
                            url: "{{ url('api/check-unique-users') }}",
                            type: "post",
                            data: {
                                phone: function () {
                                    return $("#phone").val();
                                },
                                id: {{ isset($user) ? $user->id : 0 }},
                            },
                        }
                    },
                    email: {
                        email: true,
                        remote: {
                            url: "{{ url('api/check-unique-users') }}",
                            type: "post",
                            data: {
                                email: function () {
                                    return $("#email").val();
                                },
                                table: 'teacher',
                                id: {{ isset($user) ? $user->id : 0 }},
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
                    @if(empty($user))
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    },
                    @endif
                    image: {
                        accept: "image/*"
                    }
                },
                messages: {
                    full_name: "Chưa nhập tên",
                    phone: {
                        required: "Chưa nhập số điện thoại",
                        remote: "Số điện thoại đã tồn tại trong hệ thống",
                    },
                    email: {
                        email: "Email không đúng định dạng",
                        remote: "Email đã tồn tại trong hệ thống",
                    },
                    gender: "Chưa chọn giới tính",
                    role: "Chưa nhập quyền",
                    status_id: "Chưa chọn trạng thái",
                    password: {
                        required: "Chưa nhập mật khẩu",
                        minlength: "Mật khẩu không được nhỏ hơn 6 ký tự"
                    },
                    confirm_password: {
                        required: "Chưa nhập xác nhận mật khẩu",
                        equalTo: "Mật khẩu nhập lại không chính xác"
                    }
                },
            });
        });
    </script>
@endsection
