@extends('layout.app')

<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}' rel='stylesheet'/>
<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}' rel='stylesheet' media='print'/>
<style>
    .container {
        max-width: 90% !important;
    }

    button.status.btn.white.account_relation.position {
        text-align: left;
    }

    .left-click {
        position: absolute;
        display: flex;
        flex-direction: column;
        left: -12.5%;
        top: 2%;
    }

    @media (max-width: 1366px) {
        .btn.white.account_relation.position {
            font-size: 12px;
        }
    }

</style>
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-left: 6%">
        <div class="card">
            <div class="card-header">
                <div class="left-click">
                    @foreach($taskStatus as $k => $item)
                        <div data-id="{{$k}}" class="btn white account_relation position"
                             style="background: @switch($k)
                             @case(1)
                             {{'#63cff9'}}
                             @break
                             @case(2)
                             {{'#dccf34'}}
                             @break
                             @case(3)
                             {{'#4bcc4b'}}
                             @break
                             @case(4)
                             {{'#4bcc4b'}}
                             @break
                             @case(5)
                             {{'gray'}}
                             @break
                             @case(6)
                             {{'#d03636'}}
                             @break
                             @endswitch;margin-left: 3px;text-align: left">
                            <input class="status" id="{{$k}}" type="checkbox" data-id="{{$k}}">
                            <label>{{$item}}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-2">
                    {!! Form::text('date', null, array('class' => 'form-control','id'=>'search','autocomplete'=>'off','data-toggle'=>'datepicker','placeholder'=>'Ngày hẹn')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('person_action',@$users, $user, array( 'id'=>'person_action','class' => 'form-control','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                </div>
                {{--<div class="col-md-2">--}}
                {{--{!! Form::text('customer_plus', $customer, array( 'id'=>'customer_plus','class' => 'form-control','placeholder'=>'SĐT khách hàng')) !!}--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                {{--{!! Form::select('category_id', $category,null, array( 'id'=>'category','class' => 'form-control','placeholder'=>'Nhóm DV')) !!}--}}
                {{--</div>--}}
            </div>
            <input type="hidden" id="status_val">
            <div class="side-app">
                @include('tasks.ajax2')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>

        function searchAjaxClick(datas) {
            $.ajax({
                url: "/ajax/tasks/" + id,
                method: "put",
                data: datas
            }).done(function (data) {
                $('#modal_' + id).modal('toggle');
                var b = [];
                var col = chooseColor(data.task_status_id);
                b.push({
                    id: data.id,
                    title: data.name + ' ' + data.description,
                    user_id: data.user_id,
                    start: data.date_from + 'T' + data.time_from + ':00',
                    end: data.date_from + 'T' + data.time_to + ':00',
                    type: data.type,
                    color: col,
                    //data bonus
                    description: data.description,
                    time_from: data.time_from,
                    time_to: data.time_to,
                    date: formatYMDtoDMY(data.date_from),
                    status: data.task_status_id,

                })
                $('#calendar1').fullCalendar('removeEvents', [id]);
                $('#calendar1').fullCalendar('addEventSource', b);
                console.log(data);
            })
        }

        $('#update_task').click(function () {
            let id = $('#update_id').val();
            let time_from = $('#update_time1').val();
            let time_to = $('#update_time2').val();
            let status = $('#update_status').val();
            let note = $('#update_note').val();
            searchAjaxClick({
                id: id,
                time_from: time_from,
                time_to: time_to,
                task_status_id: status,
                description: note
            });
        })

        function chooseColor(status) {
            if (status == 1)
                return '#63cff9'
            else if (status == 4)
                return '#dccf34'
            else if (status == 6)
                return '#d03636'
            else if (status == 3)
                return '#4bcc4b'
            else if (status == 5)
                return '#808080'
            else
                return ''

        }

        var arr = [];

        $('.left-click').delegate('.account_relation', 'click', function () {
            var data = $(this).attr('data-id');
            $('#' + data).click();
        });

        $('body').delegate('.status', 'click', function () {
            var data = $(this).attr('id');
            if (!$(this).is(":checked")) {
                arr = arr.filter(e => e !== data);
            } else { // if the checkbox is checked
                arr.push(data);
            }
            console.log(arr, 'arrrrr');
            // let category = $('#category').val();
            // let date = $('#search').val();
            // let user = $('#person_action').val();
            // let customer = $('#customer_plus').val();
            $.ajax({
                url: "/tasks/",
                method: "get",
                data: {
                    status: arr
                }
            }).done(function (data) {
                var b = [];
                $.each(data, function (index, data) {

                    var col = chooseColor(data.task_status_id);
                    b.push({
                        id: data.id,
                        title: data.name + ' ' + data.description,
                        user_id: data.user_id,
                        start: data.date_from + 'T' + data.time_from + ':00',
                        end: data.date_from + 'T' + data.time_to + ':00',
                        type: data.type,
                        color: col,
                        //data bonus
                        description: data.description,
                        time_from: data.time_from,
                        time_to: data.time_to,
                        date: formatYMDtoDMY(data.date_from),
                        status: data.task_status_id,
                    });
                });
                $('#calendar1').fullCalendar('removeEvents');
                $('#calendar1').fullCalendar('addEventSource', b);
                console.log(data);
            })
        });
    </script>
@endsection
