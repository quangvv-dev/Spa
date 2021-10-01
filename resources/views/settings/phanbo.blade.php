@extends('layout.app')
@section('content')
    <style>
        label.required:after {
            content: " *";
            color: red;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li><a href="#tab1" class="pages active" id="click1" data-id="'.click1'" data-toggle="tab">Cài
                                    đặt chung
                                    CRM</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="col-md-12 col-lg-12">
                                <span class="bold text-warning" style="font-size: 12px"><i
                                            class="fa fa-info-circle"></i><i>Hạn mức thăng hạng khách hàng theo số đơn hàng KH đã sử dụng !!!</i></span>
                                <div class="card">
                                    {!! Form::open(array('url' => route('settings.postPhanBo'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
                                    <div class="col row">
                                        <div class="col row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group required {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                                                    {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required')) !!}
                                                    {!! Form::select('branch_id',@$branchs, null, array('class' => 'form-control','placeholder'=>'Chọn chi nhánh','required'=>true)) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
                                                    {!! Form::label('status_id', 'Mối quan hệ', array('class' => ' required')) !!}
                                                    {!! Form::select('status_id[]',@$status, null, array('class' => 'select2 form-control','data-placeholder'=>'Chọn trạng thái','multiple'=>true,'required'=>true)) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                                    {!! Form::label('telesales_id', 'Trạng thái', array('class' => ' required')) !!}
                                                    <select name="telesales_id[]" class="form-control select2" multiple
                                                            data-placeholder="Chọn nhân viên">
                                                        <option value=""></option>
                                                        @foreach($telesales as $k => $l)
                                                           <option value="{{ $k }}">{{ $l }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <input type="hidden" name="start_date" id="start_date">
                                                <input type="hidden" name="end_date" id="end_date">
                                                {!! Form::label('s', 'Ngày tháng', array('class' => ' required')) !!}
                                                <input id="reportrange1" type="text" class="form-control square">
                                            </div>
                                            <div class="col bot" style="margin-top: 5px">
                                                <button type="submit" class="btn btn-success">Lưu
                                                </button>
                                            </div>
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
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
@endsection
@section('_script')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}


@endsection
