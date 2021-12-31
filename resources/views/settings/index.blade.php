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
                                                {!! Form::label('platinum', 'Thăng hạn rank Cộng tác viên (Platinum)', array('class' => 'control-label required')) !!}
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
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
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

        $(document).on('click', '.save-status', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
                phone: $(this).closest('tr').find('.phone').val(),
                address: $(this).closest('tr').find('.address').val(),
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
    </script>
@endsection
