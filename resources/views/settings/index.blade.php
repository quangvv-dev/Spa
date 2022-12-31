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
                            <li><a href="#tab2" class="pages" id="click2" data-id="'.click2'" data-toggle="tab">QL chi
                                    nhánh</a></li>
                            <li><a href="#tab3" class="pages" id="click3" data-id="'.click3'" data-toggle="tab">QL cụm</a></li>
                            <li><a href="#tab4" class="pages" id="click4" data-id="'.click4'" data-toggle="tab">QL độ tuổi</a></li>
                            <li><a href="#tab5" class="pages" id="click5" data-id="'.click5'" data-toggle="tab">QL nghề nghiệp</a></li>
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
                                    {!! Form::open(array('url' => route('settings.storeRank'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
                                    <div class="col row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('silver', 'Thăng hạn rank Người mua hàng (Sliver)', array('class' => 'control-label required')) !!}
                                                {!! Form::text('silver',@number_format(setting('silver')), array('class' => 'form-control')) !!}
                                                <span
                                                        class="help-block">{{ $errors->first('silver', ':message') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('platinum', 'Thăng hạn rank Khách hàng VIP', array('class' => 'control-label required')) !!}
                                                {!! Form::text('platinum',@number_format(setting('platinum')), array('class' => 'form-control')) !!}
                                                <span
                                                        class="help-block">{{ $errors->first('platinum', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('gold', 'Thăng hạn rank Khách hàng (GOLD)', array('class' => 'control-label required')) !!}
                                                {!! Form::text('gold',@@number_format(setting('gold')), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('gold', ':message') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('exchange', '% Hoa hồng CTV', array('class' => 'control-label required')) !!}
                                                {!! Form::text('exchange',@@number_format(setting('exchange')), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('exchange', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('server_call_center', 'SERVER TỔNG ĐÀI', array('class' => 'control-label required')) !!}
                                                {!! Form::select('server_call_center',[\App\Constants\StatusCode::SERVER_3CX=>'Sever 3CX',\App\Constants\StatusCode::SERVER_GTC_TELECOM=>'Server GtcTelecom' ], @setting('server_call_center'), array('class' => 'form-control','data-placeholder'=>'Danh mục cha')) !!}
                                            </div>
                                            <div class="form-group"></div>
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
                        <div class="tab-pane " id="tab2">
                            @include('settings.branch')
                        </div>
                        <div class="tab-pane" id="tab3">
                            @include('settings.location')
                        </div>
                        <div class="tab-pane" id="tab4">
                            @include('settings.age_from')
                        </div>
                        <div class="tab-pane" id="tab5">
                            @include('settings.customer_job')
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script>
        // $(document).on('click', '.pages', function () {
        //     let tab = $(this).data('id');
        //     localStorage.setItem("selectPage", tab);
        // })
        //
        // $(document).ready(function () {
        //     let page = localStorage.getItem("selectPage");
        //     page = page.toString();
        //     $('.click2').addClass('.active');
        //     console.log(page);
        //
        // })

        $(document).on('keyup', '.number', function () {
            let earn = $(this).val();
            $(this).val(formatNumber(earn));
        })

        $(document).on('click', '#add_new_status', function () {
            $.ajax({
                url: '{{route('settings.storeBranch')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })
        $(document).on('click', '#add_new_age', function () {
            $.ajax({
                url: '{{route('settings.storeAge')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })
        $(document).on('click', '#add_new_job', function () {
            $.ajax({
                url: '{{route('settings.storeJob')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })

        $(document).on('click', '#add_new_location', function () {
            $.ajax({
                url: '{{route('settings.storeLocation')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                    console.log(data);
                }
            })
        })

        $(document).on('click', '.save-status', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
                phone: $(this).closest('tr').find('.phone').val(),
                address: $(this).closest('tr').find('.address').val(),
                location_id: $(this).closest('tr').find('.location').val(),
                lat: $(this).closest('tr').find('.lat').val(),
                long: $(this).closest('tr').find('.long').val(),
            }
            $.ajax({
                url: 'branch/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
        $(document).on('click', '.save-location', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
            }
            $.ajax({
                url: 'location/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
        $(document).on('click', '.save-age-job', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
            }
            $.ajax({
                url: '/save-age-job/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })

        //sortable
        $(function () {
            $("#sortable2").sortable({ //update trạng thái khách hàng
                stop: function (event, ui) {
                    let rows = $('.table-sortable2 tbody tr');
                    let dataPosition = [];
                    console.log(rows.length)
                    for (let r = 0; r < rows.length; r++) {
                        $(rows[r]).attr('data-position', r)
                        dataPosition.push({
                            id: $(rows[r]).attr('data-id'),
                            position: r
                        })
                    }

                    swal({
                        title: 'Bạn có muộn cập nhật?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        showCloseButton: true,
                    },function () {
                        $.ajax({
                            url: '/update-age-job-position',
                            method:'put',
                            data: {
                                data:dataPosition
                            },
                            success:function (data) {
                                alertify.success('Cập nhật thành công !');
                            }
                        })
                    })
                }
            });
            $("#sortable3").sortable({ //update trạng thái khách hàng
                stop: function (event, ui) {
                    let rows = $('.table-sortable3 tbody tr');
                    let dataPosition = [];
                    console.log(rows.length)
                    for (let r = 0; r < rows.length; r++) {
                        $(rows[r]).attr('data-position', r)
                        dataPosition.push({
                            id: $(rows[r]).attr('data-id'),
                            position: r
                        })
                    }

                    swal({
                        title: 'Bạn có muộn cập nhật?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        showCloseButton: true,
                    }).then(function () {
                        $.ajax({
                            url: '/update-age-job-position',
                            method:'put',
                            data: {
                                data:dataPosition
                            },
                            success:function (data) {
                                alertify.success('Cập nhật thành công !');
                            }
                        })
                    })
                }
            });
        });
    </script>
@endsection
