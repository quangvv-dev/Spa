@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <style>
        a.nav-link.active {
            font-weight: 600;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1 ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="nav-item">
                            <a href="" class="nav-link active" >Thông tin tài khoản</a>
                        </li>
                        @if (isset($user) && auth()->user()->permission('personal.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/salary/'.$user->id)}}">Bảng lương</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/'.$user->id)}}">Hồ sơ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/images/'.$user->id)}}">Hợp đồng (file)</a>
                            </li>
                        @endif
                    </ul>
                </div>
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
                    <div class="form-group required {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                        {!! Form::label('name_display', 'Tên xuất báo cáo', array('class' => '')) !!}
                        {!! Form::text('name_display', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                        {!! Form::label('branch_id', 'Chi nhánh') !!}
                        <select id="branch_id" name="branch_id" class="form-control select2">
                            <option value="">Tất cả chi nhánh</option>
                            @forelse($branchs as $k => $item)
                                <option
                                        {{@$user->branch_id==$k?'selected':''}} value="{{$k}}">{{$item}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                </div>
                {{--<div class="col-xs-12 col-md-6">--}}
                    {{--<div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">--}}
                        {{--{!! Form::label('email', 'Email', array('class' => ' required')) !!}--}}
                        {{--{!! Form::email('email', null, array('id' => 'email', 'class' => 'form-control')) !!}--}}
                        {{--<span class="help-block">{{ $errors->first('email', ':message') }}</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

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
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('gender') ? 'has-error' : '' }}">
                        {!! Form::label('gender', 'Giới tính', array('class' => ' required')) !!}
                        {!! Form::select('gender',[0 => 'Nữ', 1 => 'Nam'], null, array('class' => 'form-control select2', 'placeholder' => 'Chọn giới tính')) !!}
                        <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <div class="form-group required {{ $errors->has('caller_number') ? 'has-error' : '' }}">
                                {!! Form::label('', 'Mã máy tổng đài (nếu có)') !!}
                                <input type="text" id="phone_center" class="form-control" value="{{isset($user)?@$user->caller_number:''}}"
                                    {{\Illuminate\Support\Facades\Auth::user()->department_id!=\App\Constants\UserConstant::ADMIN ?'disabled':'name=caller_number'}} >
                                <span class="help-block">{{ $errors->first('caller_number', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <div class="form-group required {{ $errors->has('caller_number') ? 'has-error' : '' }}">
                                {!! Form::label('', 'Mã NV') !!}
                                <input type="text" name="code" class="form-control" value="{{isset($user)?@$user->code:''}}">
                                <span class="help-block">{{ $errors->first('code', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <div class="form-group required {{ $errors->has('approval_code') ? 'has-error' : '' }}">
                                {!! Form::label('', 'Mã chấm công (nếu có)') !!}
                                <input type="text" id="approval_code" class="form-control" value="{{isset($user)?@$user->approval_code:''}}"
                                       name='approval_code'>
                                <span class="help-block">{{ $errors->first('approval_code', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\UserConstant::ADMIN)
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('department_id') ? 'has-error' : '' }}">
                            {!! Form::label('department_id', 'Phòng ban', array('class' => ' required')) !!}
                            {!! Form::select('department_id', $departments, null, array('id'=>'departments','class' => 'form-control select2', 'placeholder' => 'Phòng ban')) !!}
                            <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('role') ? 'has-error' : '' }}">
                            {!! Form::label('role', 'Quyền', array('class' => ' required')) !!}
                            <select id="role" name="role" class="form-control select2">
                                <option value="">Chọn quyền</option>
                                @if(isset($user))
                                    @forelse($role as $item)
                                        <option
                                            {{$user->role==$item->id?'selected':''}} value="{{$item->id}}">{{$item->name}}
                                        </option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('role', ':message') }}</span>
                        </div>
                    </div>
                    <input type="hidden" name="is_leader" value="0">

                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('location_id', 'Chọn cụm', array('class' => '')) !!}
                        <select name="location_id" class="form-control select2">
                            <option value="">Chọn cụm</option>
                            @forelse($location as $k => $item)
                                <option
                                        {{@$user->branch_id==$k?'selected':''}} value="{{$k}}">{{$item}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                </div>
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

        $('#departments').change(function () {
            let department_id = $(this).val();
            let html = '';
            $.ajax({
                url: "/ajax/find-role/" + department_id,
                method: "get",
            }).done(function (data) {
                data.forEach(element => {
                    html += `<option value="` + element.id + `">` + element.name + `</option>`
                });
                $('#role').html(html);
            });
        });
    </script>
@endsection
