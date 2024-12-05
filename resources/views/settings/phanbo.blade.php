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
                                            class="fa fa-info-circle"></i><i>Phân bổ data khách hàng hàng loạt !!!</i></span>
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
                                            <div class="col-xs-12 col-md-6 row">
                                                <div class="col">
                                                    {!! Form::label('','Ngày bắt đầu') !!}
                                                    <input type="text" class="form-control filter_start_date" id="datepicker"
                                                           data-toggle="datepicker" name="start_date">
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('','Ngày kết thúc') !!}
                                                    <input type="text" class="form-control filter_end_date" id="datepicker"
                                                           data-toggle="datepicker" name="end_date">
                                                </div>
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
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}


@endsection
