@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
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
                            <a href="" class="nav-link active">Thông tin tài khoản</a>
                        </li>
                        @if(isset($user))
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/salary/'.$user->id)}}">Bảng lương</a>
                            </li>
                            @if (auth()->user()->permission('personal.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('personal/'.$user->id)}}">Hồ sơ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('personal/images/'.$user->id)}}">Hợp đồng (file)</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>

            @if (isset($user))
                {!! Form::model($user, array('url' => route('errors.monitoring.update',$user->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('errors.monitoring.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('date_check') ? 'has-error' : '' }}">
                        {!! Form::label('date_check', 'Ngày vi phạm', array('class' => ' required')) !!}
                        <input class="form-control" data-toggle="datepicker" name="date_check">
                        <span class="help-block">{{ $errors->first('date_check', ':message') }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 clockpicker" data-placement="left" data-align="top"
                     data-autoclose="true">
                    {!! Form::label('time', 'Giờ mắc lỗi', array('class' => ' required')) !!}
                    {!! Form::text('time', null, array('class' => 'form-control','required'=>true)) !!}
                </div>

                <div class="col-xs-12 col-md-6">
                    {!! Form::label('position_id', 'Vị trí giám sát', array('class' => ' required')) !!}
                    {!! Form::select('position_id',$position, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn vị trí--', 'required' => true)) !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! Form::label('user_id', 'Nhân viên vi phạm', array('class' => ' required')) !!}
                    {!! Form::select('user_id',$users, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn nhân viên--', 'required' => true)) !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! Form::label('classify_id', 'Phân loại quy trình', array('class' => ' required')) !!}
                    {!! Form::select('classify_id',$classify, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn quy trình--', 'required' => true)) !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! Form::label('block_id', 'Khối', array('class' => ' required')) !!}
                    {!! Form::select('block_id',$block, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn khối--', 'required' => true)) !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! Form::label('error_id', 'Lỗi vi phạm', array('class' => ' required')) !!}
                    {!! Form::select('error_id',$error, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn lỗi vi phạm--', 'required' => true)) !!}
                </div>
                <div class="col-xs-12 col-md-6">
                    {!! Form::label('note', 'Mô tả') !!}
                    {!! Form::textArea('note', null, array('class' => 'form-control header-search','rows'=> 3)) !!}
                </div>

                @if(\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\UserConstant::ADMIN)
                    {{--                    <div class="col-xs-12 col-md-6">--}}
                    {{--                        <div class="form-group required {{ $errors->has('department_id') ? 'has-error' : '' }}">--}}
                    {{--                            {!! Form::label('department_id', 'Phòng ban', array('class' => ' required')) !!}--}}
                    {{--                            {!! Form::select('department_id', $departments, null, array('id'=>'departments','class' => 'form-control select2', 'placeholder' => 'Phòng ban')) !!}--}}
                    {{--                            <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <input type="hidden" name="is_leader" value="0">--}}

                @endif
                {{--                <div class="col-xs-12 col-md-6">--}}
                {{--                    <div class="form-group">--}}
                {{--                        {!! Form::label('location_id', 'Chọn cụm', array('class' => '')) !!}--}}
                {{--                        <select name="location_id" class="form-control select2">--}}
                {{--                            <option value="">Chọn cụm</option>--}}
                {{--                            @forelse($location as $k => $item)--}}
                {{--                                <option--}}
                {{--                                        {{@$user->branch_id==$k?'selected':''}} value="{{$k}}">{{$item}}--}}
                {{--                                </option>--}}
                {{--                            @empty--}}
                {{--                            @endforelse--}}
                {{--                        </select>--}}
                {{--                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


            </div>
            <div class="col" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('errors.monitoring.index')}}" class="btn btn-danger">Trở lại</a>
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

        $('document').ready(function () {
            $('.clockpicker').clockpicker();
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>
@endsection
