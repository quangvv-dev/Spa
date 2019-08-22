@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{asset('/assets/plugins/wysiwyag/richtext.min.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6 no-padd font16"><a class="avatar a45 fl mr10 pic"> <img
                                src="https://linhanhspa.getflycrm.com/assets/images/noavatar.png"> </a> <span
                            class="bold uppercase ">  {{ $customer->full_name }}  </span>
                    <div class="display" id="toolbox"><a rel="tooltip" data-original-title="Sửa"
                                                         data-placement="bottom" class="ml10"
                                                         href="#/crm/account/4629"><i
                                    class="icon-pencil mr5"></i></a> <a id="btn_del_account" rel="tooltip"
                                                                        data-placement="bottom"
                                                                        data-original-title="Xóa" class="ml5"><i
                                    class="gf-icon-hover icon-remove mr5"></i></a></div>
                </div>
                <div class="col-md-2 no-padd bor-l pl20 mg0 pt10 position hoverlastactive" rel="tooltip"
                     data-original-title="Click thay đổi người phụ trách" data-placement="bottom">
                    <div class="show_change_am" style="cursor:pointer">
                        <div class="avatar a35"><img class="account_manager_avatar"
                                                     src="https://linhanhspa.getflycrm.com/assets/images/noavatar.png">
                        </div>
                        <div class="info-avatar"><p class="account_manager_name"><a class="gfname">{{ @$customer->telesale->full_name }}</a>
                            </p>
                            <p class="gray1 font12">Người phụ trách</p></div>
                    </div>
                </div>
                <div class="col-md-1 no-padd bor-l mg0 position hoverlastactive" rel="tooltip"
                     data-original-title="Click thay đổi liên hệ lần cuối" data-placement="bottom">
                    {{--<div class="last_active tc" style="cursor:pointer"><h1 id="days_from_last_active"--}}
                                                                           {{--style="font-size:30px" class="bold mg0">--}}
                            {{--1</h1>--}}
                        {{--<p>Liên hệ lần cuối</p></div>--}}
                    {{--<div class="add-drop add-d-left other_last_active"--}}
                         {{--style="right: 125px; top: 60px; width: 286px; padding: 10px; z-index: 12; border: 1px solid rgb(208, 208, 208); display: none;">--}}
                        {{--<s class="gf-icon-neotop"></s>--}}
                        {{--<div class="col-md-12 no-padd"><p>Liên hệ lần cuối</p>--}}
                            {{--<div class=""><input type="text" placeholder="Thời gian" class="datepick form-control"--}}
                                                 {{--id="date_last_active" value="22/08/2019 18:24:01"></div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-12 no-padd mt10"><p>Nội dung <span class="red">(*)</span></p> <textarea--}}
                                    {{--class="content_last_active form-control" cols="4"--}}
                                    {{--style="height:80px"></textarea></div>--}}
                        {{--<div class="col-md-12 no-padd mt10">--}}
                            {{--<button class="btn btn-info submit_last_active">Cập nhật</button>--}}
                            {{--<button class="btn btn-default submit_and_create_comment">Cập nhật và tạo trao đổi--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="col-md-1 no-padd tc bor-l mg0"><h1 style="font-size:30px" class="bold mg0">0</h1>
                    <p>Tương tác</p></div>
                <div class="col-md-2 no-padd tc bor-l mg0"><h1 style="font-size:30px" class="bold mg0">0</h1>
                    <p>Giá trị</p></div>
            </div>
            <div style="height:5px" class="color-picker-bg-41"></div>
            <div class="col-md-12 no-padd">
                <div class="col-md-2 no-padd" style="float: left; display: block">
                    <div class="full2 pb20 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2"><h3 class="uppercase pb5 mb10 font12 bold mg0">Mối
                                quan hệ</h3>
                            <div class="">{{ $customer->status->name }}
                            </div>
                        </div>
                    </div>
                    <div class="border padding infor-list-ct ml2 mt10"><h3
                                class="uppercase pb5 mb10 font12 bold mg0">Liên hệ</h3>
                        <div class="box-cont">
                            <div class="list-row-ifct mb10 pb10 clearfix contact_item" data-contact-id="4658">
                                <div class="col-md-12 no-padd mt2 gray fl mb10"><p class="clearfix white-space"><i
                                                class="icon-user mr5 mt2 fl"></i> <b class="blue">{{ $customer->full_name }}</b> <i
                                                data-original-title="Liên hệ chính" rel="tooltip"
                                                class="fa orange fa-star" aria-hidden="true"></i></p>
                                    <p></p>
                                    <p class="clearfix">{{ $customer->phone }}</p>
                                </div>
                                <div class="col-md-12 no-padd hide"><a><i data-task-type="2"
                                                                          class="tc new_popup_task icon-phone style-icon-phone mr10 fl"></i></a>
                                    <a><i data-task-type="3"
                                          class="tc new_popup_task icon-group style-icon-group mr10 fl"></i></a> <a><i
                                                data-task-type="4"
                                                class="tc new_popup_task icon-envelope-alt style-icon-envelope mr10 fl"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border padding mt10 ml2">
                        <div class="infor-top-ct"><h3 class="uppercase mb10 font12 bold mg0"
                                                      style="margin-bottom: 10px!important;">Thông tin khách
                                hàng</h3>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mã KH:</p>
                                <p class="bold word-wrap"> {{$customer->account_code}}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tên KH:</p>
                                <p class="bold word-wrap"> {{ $customer->full_name }} </p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Địa chỉ:</p>
                                <p class="bold word-wrap"> {{ $customer->address }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Điện thoại:</p>
                                <p class="bold word-wrap"><a class="" data-account-id="4629" data-phone="0904341335"
                                                             data-type="crm" data-issensitive="true"> 
                                         {{ $customer->phone }} </a></p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Người phụ trách:</p>
                                <p class="bold word-wrap"> {{ @$customer->telesale->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Nhóm KH:</p>
                                <p class="bold word-wrap"> {{ @$customer->category->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Nguồn KH:</p>
                                <p class="bold word-wrap"> {{ @$customer->source_customer->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Sinh nhật:</p>
                                <p class="bold word-wrap"> {{ $customer->birthday }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mối quan hệ:</p>
                                <p class="bold word-wrap"> {{ $customer->status->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Ngày tạo:</p>
                                <p class="bold word-wrap"> {{ $customer->created_at }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Giới tính:</p>
                                <p class="bold word-wrap"> {{ $customer->genderText }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mô tả:</p>
                                <p class="bold word-wrap"> {{ $customer->description }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Số đơn hàng:</p>
                                <p class="bold word-wrap"> {{ $customer->orders->count() }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tổng doanh thu:</p>
                                <p class="bold word-wrap"> {{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tổng số tương tác:</p>
                                <p class="bold word-wrap">0</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Giá trị:</p>
                                <p class="bold word-wrap"> {{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 no-padd" style="float: left;">
                    <div class="col-md-9 no-padd spanfull2 padding" style="float: left;">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{$title}}</h3></br>
                                    <div class="col" style="float: right">
                                        <a class="right btn btn-primary btn-flat"
                                           href="{{ url('schedules/'.request()->segment(count(request()->segments())) ) }}"><i
                                                    class="fa fa-arrow-right"></i>Tới đặt lịch</a>
                                    </div>
                                </div>
                                {!! Form::open(array('url' => url('group_comments/'.request()->segment(count(request()->segments())) ), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                                <div class="col-md-12">
                                    {!! Form::textArea('messages', null, array('class' => 'messages')) !!}
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <button style="float: right" type="submit" class="btn btn-success">Gửi</button>
                                </div>
                                {{ Form::close() }}

                                <div id="registration-form">
                                    @include('group_comment.ajax')
                                </div>
                                <!-- table-responsive -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 no-padd bor-l bor-bot" style="float: left;">
                        <div class="col-md-12 no-padd padding">
                                <div class="col-md-12 fl mt5"><i class="fa fa-random mr5 gray"></i> Nguồn: <span
                                            class="bold"> {{ @$customer->source_customer->name }}</span>
                                </div>
                                <div class="col-md-12 fl mt5">
                                    <i class="fa fa-user mr5 gray"></i> Người tạo: {{ @$customer->marketing->full_name }}
                                </div>
                                <div class="col-md-12 fl mt5">
                                    <i class="fa fa-calendar mr5 gray"></i> Ngày tạo: <span class="bold">{{ $customer->created_at }}</span>
                                </div>
                                <div class="col-md-12 fl mt5">
                                    <i class="fa fa-shopping-cart mr5 gray"></i> Đã mua: {{ @$customer->orders->count() }}
                                </div>
                                {{--<div class="col-md-12">--}}
                                    {{--<i class="fa fa-calendar mr5 gray"></i> Lần mua gần nhất:--}}
                                {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>

    <script type="text/javascript">

        $(function (e) {
            $('.messages').richText();
        });
    </script>
@endsection