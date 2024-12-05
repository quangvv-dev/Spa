<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pu-caption mt-1">TÀI KHOẢN FACEBOOK</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-center">
                        @if(isset($data_login_fb) && $data_login_fb)
                            <img src="{{$data_login_fb->avatar}}"
                                 alt="" style="border-radius:50%; width: 100px; ">
                            <h3 class="profile-username text-center">
                                <a href="javascript:void(0);" target="_blank"><i
                                        class="fa fa-facebook-official"
                                        style="color: #3c8dbc;"></i>&nbsp;
                                    {{$data_login_fb->name}}
                                </a>
                            </h3>
                            <a class="btn btn-block btn-social btn-danger bg-pink-custom height-35"
                               href="{{route('facebook.removeAccount')}}">
                                <i class="fa fa-facebook"></i>Remove Account
                            </a>
                        @else
                            <img src="{{asset('images/avatar.jpg')}}"
                                 alt="" style="border-radius:50%; width: 100px; ">
                            <h3 class="profile-username text-center">
                                <a href="javascript:void(0);" target="_blank"><i
                                        class="fa fa-facebook-official"
                                        style="color: #3c8dbc;"></i>&nbsp; Username
                                </a>
                            </h3>
                            <a class="btn btn-block btn-social btn-danger bg-pink-custom height-35"
                               href="{{route('facebook.login')}}">
                                <i class="fa fa-facebook"></i>Login With Facebook
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pu-caption">THÔNG TIN FACEBOOK</div>
            <div class="card-body tableFixHead" style="padding-left: 15px;">
                <table class="table table-hover" style="font-size: 12px">
                    <tbody>
                    <tr>
                        <td style="width:40%;">Tên:</td>
                        <td style="width:60%;" class="">
                            <a class="_FBName max-1-row">{{isset($data_login_fb) && $data_login_fb->name ? $data_login_fb->name :''}}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:40%;">Email:</td>
                        <td style="width:60%;" class=""><a
                                class="_FBEmail max-1-row">{{isset($data_login_fb) && $data_login_fb->email? $data_login_fb->email :''}}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:40%;">Số Fanpage:</td>
                        <td style="width:60%;" class=""><a
                                id="dnn_ctr1500_Main_QuanLy__FBCountGroups"
                                class="_FBCountGroups max-1-row">{{count($fanpages)}}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
