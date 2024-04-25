@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <style>
        .btn-new {
            color: #fff;
            font-weight: 600;
        }

        .noti-reletion {
            background: #f36a26;
            font-size: 10px;
            padding: 0 5px;
            position: absolute;
            color: #fff;
            border-radius: 10px;
            top: -8px;
            border: 2px solid #fff;
        }

        .not-number-account, .not-number-customer {
            font-weight: 700;
            display: block;
            line-height: 13px;
        }
        a.tag{
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Theo dõi công việc nhân viên</h3>

            </div>
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="card-header">
                <div class="col-md-2">
                    {!! Form::select('user_id', $users, null, array('class' => 'form-control sale select2','placeholder'=>'Tất cả sale')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('type', [\App\Constants\NotificationConstant::CSKH=>'CSKH',\App\Constants\NotificationConstant::CALL=>'Gọi điện'], null, array('class' => 'form-control type','placeholder'=>'Tất cả công việc')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('role', \App\Models\Task::ROLE, null, array('class' => 'form-control type','placeholder'=>'Công việc của tôi')) !!}
                </div>
{{--                <div class="col-md-2">--}}
{{--                    {!! Form::select('task_status_id', [\App\Constants\StatusCode::NEW_TASK=>'Mới',\App\Constants\StatusCode::DONE_TASK=>'Hoàn thành',\App\Constants\StatusCode::FAILED_TASK=>'Quá hạn'], null, array('class' => 'form-control task-status','placeholder'=>'Tất cả trạng thái')) !!}--}}
{{--                </div>--}}
                <div class="col-md-3">
                    <input type="hidden" name="task_status_id" id="status">
                    <input type="hidden" name="page" id="page">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">
                    <input id="reportrange" type="text" class="form-control square">
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary"> Tìm kiếm
                    </button>
                </div>
            </div>
            {{ Form::close() }}
            @include('kanban_board.modal')
            <div id="registration-form">
                @include('tasks.ajax_statistical')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script type="text/javascript">

            $(document).on('click', '.tag', function(e) {
                let data = $(this).data('content');
                console.log(data)

                $('#name').val(data.name).change();
                // $("a[href]").attr("href",link);
                $('.name-customer').html(data.customer.full_name+'  ('+data.customer.account_code+')').change();
                $('.phone-customer').val(data.customer.phone).change();
                $('#user_id').val(data.user.full_name).change();
                $('#date_from').val(data.date_from).change();
                $('#time_from').val(data.time_from).change();
                $('#time_to').val(data.time_to).change();
                $('#description').html(data.description).change();
                $('.checkTask').attr('data-id',data.id);
                if(data.task_status_id == 3){
                    $('.checkTask').attr('checked','checked');
                }else {
                    $('.checkTask').attr('checked',false);
                }
            });

            $(document).on('click', '.checkTask', function(e) {
                let val = $(this).val();
                console.log(val);
                if(val == "on"){
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/tasks/update',
                        data: {
                            id: $(this).data('id'),
                        },
                        success: function () {
                            alertify.success('Hoàn thành công việc');
                        }
                    })
                }
            });
            $(document).on('click', 'a.page-link', function (e) {
                e.preventDefault();
                let pages = $(this).attr('href').split('page=')[1];
                $('#page').val(pages);
                $('#gridForm').submit();
            });
            $(document).on('click', '.btn-new', function (e) {
                e.preventDefault();
                $('#status').val($(this).data('id'));
                $('#gridForm').submit();
            });
    </script>
@endsection
