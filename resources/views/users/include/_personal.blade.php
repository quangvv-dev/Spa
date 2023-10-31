@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
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
                            <a href="{{route('users.edit',$user->id)}}" class="nav-link" >Thông tin tài khoản</a>
                        </li>
                        @if(isset($user))
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('personal/salary/'.$user->id)}}">Bảng lương</a>
                        </li>
                        @if (auth()->user()->permission('personal.index'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{url('personal/'.$user->id)}}">Hồ sơ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('personal/images/'.$user->id)}}">Hợp đồng (file)</a>
                        </li>
                        @endif
                        @endif
                    </ul>
                </div>
            </div>

            {!! Form::open(array('url' => url('personal/'.$user->id), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            <div class="col row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('cccd') ? 'has-error' : '' }}">
                        {!! Form::label('cccd', 'Số CCCD', array('class' => ' required')) !!}
                        {!! Form::text('cccd', @$user->personal->cccd, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('cccd', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('insurance_number') ? 'has-error' : '' }}">
                        {!! Form::label('insurance_number', 'Số BHXH') !!}
                        {!! Form::text('insurance_number', @$user->personal->insurance_number, array('id' => 'insurance_number','class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('insurance_number', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                        {!! Form::label('birthday', 'Ngày sinh', array('class' => '')) !!}
                        {!! Form::text('birthday', !empty($user->personal->birthday)?date('d/m/Y',strtotime($user->personal->birthday)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('birthday', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('start_probation') ? 'has-error' : '' }}">
                        {!! Form::label('start_probation', 'Ngày BĐ thử việc', array('class' => '')) !!}
                        {!! Form::text('start_probation',!empty($user->personal->start_probation)?@date('d/m/Y',strtotime($user->personal->start_probation)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('start_probation', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('start_work') ? 'has-error' : '' }}">
                        {!! Form::label('start_work', 'Ngày làm việc chính thức 1', array('class' => '')) !!}
                        {!! Form::text('start_work',!empty($user->personal->start_work)?@date('d/m/Y',strtotime($user->personal->start_work)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('start_work', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('insurance_time') ? 'has-error' : '' }}">
                        {!! Form::label('insurance_time', 'Ngày BĐ đóng BHXH', array('class' => '')) !!}
                        {!! Form::text('insurance_time',!empty($user->personal->insurance_time)?@date('d/m/Y',strtotime($user->personal->insurance_time)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('insurance_time', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('pause_time') ? 'has-error' : '' }}">
                        {!! Form::label('pause_time', 'Thời gian tạm nghỉ (Thai sản/ốm)', array('class' => '')) !!}
                        {!! Form::text('pause_time',!empty($user->personal->pause_time)?@date('d/m/Y',strtotime($user->personal->pause_time)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('pause_time', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('leave_time') ? 'has-error' : '' }}">
                        {!! Form::label('leave_time', 'Thời gian nghỉ việc', array('class' => '')) !!}
                        {!! Form::text('leave_time',!empty($user->personal->leave_time)?@date('d/m/Y',strtotime($user->personal->leave_time)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('leave_time', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('insurance_time') ? 'has-error' : '' }}">
                        {!! Form::label('insurance_time', 'Ngày BĐ đóng BHXH', array('class' => '')) !!}
                        {!! Form::text('insurance_time',!empty($user->personal->insurance_time)?@date('d/m/Y',strtotime($user->personal->insurance_time)):null, array('class' => 'form-control singleDate')) !!}
                        <span class="help-block">{{ $errors->first('insurance_time', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                        {!! Form::label('position_id', 'Hạng nhân viên') !!}
                        <select id="position_id" name="position_id" class="form-control select2">
                            <option value="">--Hạng nhân viên--</option>
                            @forelse($positions as $k => $item)
                                <option
                                    {{@$user->personal->position_id == $item->id?'selected':''}} value="{{$item->id}}">{{$item->name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <span class="help-block">{{ $errors->first('position_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('leave_reason_id') ? 'has-error' : '' }}">
                        {!! Form::label('leave_reason_id', 'Lý do nghỉ việc') !!}
                        <select id="leave_reason_id" name="leave_reason_id" class="form-control select2">
                            <option value="">--Lý do nghỉ việc--</option>
                            @forelse($leave_reason as $k => $item)
                                <option
                                    {{@$user->personal->leave_reason_id == $item->id?'selected':''}} value="{{$item->id}}">{{$item->name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <span class="help-block">{{ $errors->first('leave_reason_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12">
                    <div class="form-group required {{ $errors->has('note') ? 'has-error' : '' }}">
                        {!! Form::label('note', 'Gia cảnh nhân sự', array('class' => '')) !!}
                        {!! Form::textArea('note', @$user->personal->note, array('class' => 'form-control','rows'=>3)) !!}
                        <span class="help-block">{{ $errors->first('pause_time', ':message') }}</span>
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
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
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
