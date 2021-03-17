@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
@endsection
@section('content')
    <style>
        label.required:after {
            content: " *";
            color: red;
        }
    </style>
    @php
     $permissions = setting('permissions');
    @endphp
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab1" class="active" data-toggle="tab">Cài đặt chung SUPER ADMIN</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active " id="tab1">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    {!! Form::open(array('url' => route('settings.storeAdmin'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
                                    <div class="col row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('title_website', 'Tiêu đề website', array('class' => 'control-label required')) !!}
                                                {!! Form::text('title_website',setting('title_website'), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('title_website', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group required {{ $errors->has('logo_website') ? 'has-error' : '' }}">
                                                {!! Form::label('logo_website', 'Ảnh đại diện') !!}
                                                <div class="fileupload fileupload-{{!empty(setting('logo_website')) ? 'exists' : 'new' }}"
                                                     data-provides="fileupload">
                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px">
                                                        @if(!empty(setting('logo_website')))
                                                            <img src="{{ setting('logo_website') }}" alt="image"/>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-default btn-file">
                                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                                                            <input type="file" name="logo_website" accept="image/*" class="btn-default upload"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table-responsive col-md-12">
                                            <table id="list-user" class="table table-bordered table-hover">
                                                <thead class="bg-info text-white">
                                                <tr>
                                                    <th>Quyền</th>
                                                    <th>Ẩn</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Quản lý tin nhắn</td>
                                                    <td>
                                                        <input type="checkbox" id="input173" name="permissions[]"
                                                               value="sms.index" {{!empty($permissions) && in_array('sms.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý gói nạp ví</td>
                                                    <td>
                                                        <input type="checkbox" id="input174" name="permissions[]"
                                                               value="package.index" {{!empty($permissions) && in_array('package.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý nạp tiền (Chi tiết khách hàng)</td>
                                                    <td>
                                                        <input type="checkbox" id="input174" name="permissions[]"
                                                               value="package.customer" {{!empty($permissions) && in_array('package.customer',$permissions) ? 'checked' : ''}}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý hạn mức thăng hạng rank</td>
                                                    <td>
                                                        <input type="checkbox" id="input175" name="permissions[]"
                                                               value="settings.index" {{!empty($permissions) && in_array('settings.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                {{--<tr>--}}
                                                    {{--<td>Chiến dịch khuyến mại (chi t)</td>--}}
                                                    {{--<td>--}}
                                                        {{--<input type="checkbox" id="input176" name="permissions[]"--}}
                                                               {{--value="home" {{!empty($permissions) && in_array('sms.index',$permissions) ? 'checked' : ''}}>--}}
                                                    {{--</td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td>Quản lý voucher khuyến mại</td>
                                                    <td>
                                                        <input type="checkbox" id="input177" name="permissions[]"
                                                               value="promotions.index" {{!empty($permissions) && in_array('promotions.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý landingPage</td>
                                                    <td>
                                                        <input type="checkbox" id="input178" name="permissions[]"
                                                               value="landipages.index" {{!empty($permissions) && in_array('landipages.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý optin form</td>
                                                    <td>
                                                        <input type="checkbox" id="input178" name="permissions[]"
                                                               value="posts.index" {{!empty($permissions) && in_array('posts.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Khách hàng từ form</td>
                                                    <td>
                                                        <input type="checkbox" id="input178" name="permissions[]"
                                                               value="customer-post.index" {{!empty($permissions) && in_array('customer-post.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quản lý automation</td>
                                                    <td>
                                                        <input type="checkbox" id="input178" name="permissions[]"
                                                               value="rules.index" {{!empty($permissions) && in_array('rules.index',$permissions) ? 'checked' : ''}}>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Xem thông báo</td>
                                                    <td>
                                                        <input type="checkbox" id="input178" name="permissions[]"
                                                               value="the_last">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col bot" style="margin-top: 5px">
                                            <button type="submit" class="btn btn-success" id="click-sent">Lưu
                                            </button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script src="{{asset('js/format-number.js')}}"></script>
    <script>
        $(document).on('keyup', '.number', function () {
            let earn = $(this).val();
            $(this).val(formatNumber(earn));
        })
    </script>
@endsection
