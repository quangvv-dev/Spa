<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách lịch hẹn</h3></br>
            <div class="col">
                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::ADMIN
                    ||\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::WAITER)
                    <a style="margin-left: 0.5%;" class="right btn btn-primary btn-flat" href="{{ url('orders') }}"><i
                                class="fa fa-arrow-right"></i>Tới tạo đơn hàng</a>
                @endif
                <a style="color: #ffffff" class="right btn btn-primary btn-flat" data-toggle="modal"
                   data-target="#myModal"><i class="fa fa-plus-circle"></i>Thêm mới</a>
            </div>
        </div>

        <div class="card-header">
            <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                   type="search">
            {{--                <div class="col-md-2">--}}
            {{--                    {!! Form::select('type',$category_pluck, null, array('class' => 'form-control header-search','data-placeholder'=>'Danh mục cha')) !!}--}}
            {{--                </div>--}}
        </div>

        <div id="registration-form">
            @include('schedules.ajax')
        </div>
        <!-- table-responsive -->
    </div>
</div>
