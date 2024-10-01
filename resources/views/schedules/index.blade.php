<div class="col-md-12 col-lg-12">
    <div class="card" style="background-color: #131313">
        <div class="card-header">
            <h3 class="card-title linear-text fs-24">Danh sách lịch hẹn</h3></br>
            <div class="col">
{{--                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::ADMIN--}}
{{--                    ||\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::WAITER)--}}
{{--                    <a style="margin-left: 0.5%;" class="right btn btn-primary btn-flat" href="{{ url('orders') }}"><i--}}
{{--                                class="fa fa-arrow-right"></i>Tới tạo đơn hàng</a>--}}
{{--                @endif--}}
                <a style="color: #ffffff" class="right btn btn-primary" data-toggle="modal"
                   data-target="#myModal">Tạo mới</a>
            </div>
        </div>

        <div id="registration-form" class="customer-schedules">
            @include('schedules.ajax')
        </div>
        <!-- table-responsive -->
    </div>
</div>
<script src="{{asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
