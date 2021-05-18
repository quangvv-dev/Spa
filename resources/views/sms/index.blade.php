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
                            <li class=""><a href="#tab5" class="active"
                                            data-toggle="tab">Chiến dịch nhắn tin</a>
                            </li>
                            <li><a href="#tab7" class="" data-toggle="tab">Gủi tin hệ thống</a></li>
                            <li><a href="#tab8" class="" data-toggle="tab">Tin báo lịch hẹn</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active " id="tab5">
                            @include('sms.content_automation')
                        </div>
                        <div class="tab-pane" id="tab7">
                            @include('sms.sent_sms')
                        </div>
                        <div class="tab-pane" id="tab8">
                            @include('sms.schedules_sms')
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.5/jquery.textcomplete.min.js"></script>
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
