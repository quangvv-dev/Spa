@extends('layout.app')
@section('content')
    <style>
        label {
            margin-top: 9px;
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
{{--                            <li class=""><a href="#tab5" class="active" data-toggle="tab">Nội dung tin Automation</a>--}}
{{--                            </li>--}}
                            <li><a href="#tab7" class="active" data-toggle="tab">Gủi tin hệ thống</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
{{--                        <div class="tab-pane active " id="tab5">--}}
{{--                            @include('sms.content_automation')--}}
{{--                        </div>--}}
                        <div class="tab-pane active" id="tab7">
                            @include('sms.sent_sms')
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

