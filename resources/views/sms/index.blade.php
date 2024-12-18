@extends('layout.app')
@section('content')
    <style>
        label {
            margin-top: 9px;
        }

        ul.dropdown-menu.textcomplete-dropdown {
            z-index: 99999 !important;
        }

        .modal.is-open {
            display: block;
        }

        .modal__overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="">
                                <a href="#tab5" class="" data-toggle="tab">Chiến dịch nhắn tin</a>
                            </li>
                            <li><a href="#tab7" class="" data-toggle="tab">Gửi tin chiến dịch</a></li>
                            <li><a href="#tab9" class="active" data-toggle="tab">Gửi tin hàng loạt</a></li>
                            <li><a href="#tab8" class="" data-toggle="tab">Nhắc báo lịch hẹn</a></li>
                            <li><a href="#tab6" class="" data-toggle="tab">Nhắc báo cuộc gọi lỡ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane " id="tab5">
                            @include('sms.content_automation')
                        </div>
                        <div class="tab-pane" id="tab7">
                            @include('sms.sent_sms')
                        </div>
                        <div class="tab-pane" id="tab8">
                            @include('sms.schedules_sms')
                        </div>
                        <div class="tab-pane active" id="tab9">
                            @include('sms.sms_multiple')
                        </div>
                        <div class="tab-pane" id="tab6">
                            @include('sms.miss_call')
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="{{asset('js/jquery.textcomplete.min.js')}}"></script>
    <script>
        $('.autocomplete-textarea').textcomplete([{
            match: /(^|\s)@(\w*(?:\s*\w*))$/,

            search: function (query, callback) {
                let data = [{
                    name: "Tên khách hàng",
                    value: "%full_name%"
                }, {
                    name: "Ngày đặt lịch",
                    value: "%date%"
                }, {
                    name: "Giờ bắt đầu",
                    value: "%time_from%"
                }, {
                    name: "Giờ kết thúc",
                    value: "%time_to%"
                },{
                    name: "Chi nhánh",
                    value: "%branch%"
                }, {
                    name: "SĐT chi nhánh",
                    value: "%phoneBranch%"
                },{
                    name: "Địa chỉ chi nhánh",
                    value: "%addressBranch%"
                }];
                callback(data);
            },

            template: function (hit) {
                // phan hien thi o dropdown
                let html = `
            <a class="tag-item" href="">
            <span class="label">${hit.name} <img width="40" src='{{asset('/assets/images/brand/logo.png')}}'/></span>
            </a>`;
                return html;
            },

            replace: function (hit) {
                // phan hien thi khi
                return hit.value.trim();
            }
        }]);
    </script>
@endsection
{{--@section('_script')--}}
{{--@endsection--}}
