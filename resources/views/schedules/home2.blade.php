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
        left: -13.5%;
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
                    @foreach($color as $k => $item)
                        <div data-id="{{$k}}" class="btn white account_relation position"
                             style="background: @switch($k)
                             @case(1)
                             {{'#63cff9'}}
                             @break
                             @case(2)
                             {{'#dccf34'}}
                             @break
                             @case(3)
                             {{'#d03636'}}
                             @break
                             @case(4)
                             {{'#4bcc4b'}}
                             @break
                             @case(5)
                             {{'gray'}}
                             @break
                             @case(6)
                             {{'#da70dc'}}
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
                    {!! Form::select('person_action',@$staff2, $user, array( 'id'=>'person_action','class' => 'form-control','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('customer_plus', $customer, array( 'id'=>'customer_plus','class' => 'form-control','placeholder'=>'SĐT khách hàng')) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('category_id', $category,null, array( 'id'=>'category','class' => 'form-control','placeholder'=>'Nhóm DV')) !!}
                </div>
            </div>
            <input type="hidden" id="status_val">
            <div class="side-app">
                @include('schedules.ajax2')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            $('.page-title').hide();
            $('.breadcrumb').hide();

            function searchAjax(data) {
                $.ajax({
                    url: "{{ Url('schedules/') }}",
                    method: "get",
                    data: data
                }).done(function (data) {
                    var b = [];
                    $.each(data, function (index, value) {

                        switch (value.status) {
                            case 1:
                                var col = '#63cff9'
                                break;
                            case 2:
                                var col = '#dccf34'
                                break;
                            case 3:
                                var col = '#d03636'
                                break;
                            case 4:
                                var col = '#4bcc4b'
                                break;
                            case 5:
                                var col = '#808080'
                                break;
                            default:
                            // code block
                        }
                        b.push({
                            id: value.id,
                            title: 'KH: ' + value.customer.full_name + ', SĐT: ' + value.customer.phone + ' Lưu ý: ' + value.note,
                            start: value.date + 'T' + value.time_from + ':00',
                            end: value.date + 'T' + value.time_to + ':00',
                            color: col,
                            //data bonus
                            note: value.note,
                            full_name: value.customer.full_name,
                            phone: value.customer.phone,
                            creator_id: value.creator_id,
                            time_from: value.time_from,
                            time_to: value.time_to,
                            category_id: value.category_id,
                            date: formatYMDtoDMY(value.date),
                            status: value.status,
                        });
                    });
                    $('#calendar1').fullCalendar('removeEvents');
                    $('#calendar1').fullCalendar('addEventSource', b);
                });
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
                let category = $('#category').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({search: arr, category: category, date: date, user: user, customer: customer});
            });
            $(document).on('change', '#search', function () {
                $('.spin').show();
                var val = $(this).val();
                let category = $('#category').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({date: val, category: category, search: arr, user: user, customer: customer});
            });
            $(document).on('change', '#category', function () {
                $('.spin').show();
                var val = $(this).val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({category: val, date: date, search: arr, user: user, customer: customer});
            });
            $(document).on('change', '#person_action', function () {
                var val = $(this).val();
                let category = $('#category').val();
                let date = $('#search').val();
                let customer = $('#customer_plus').val();
                searchAjax({user: val, category: category, date: date, search: arr, customer: customer});

            });
            $(document).on('change', '#customer_plus', function () {
                var val = $(this).val();
                let category = $('#category').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                searchAjax({customer: val, category: category, user: user, date: date, search: arr});

            });

            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd/mm/yyyy',
                autoHide: true,
                zIndex: 2048,
            });

            $('#update_schedule').click(function () {
                let id = $('#update_id').val();
                let date = $('#update_date').val();
                let time_from = $('#update_time1').val();
                let time_to = $('#update_time2').val();
                let status = $('#update_status').val();
                let category_id = $('#update_category').val();
                let note = $('#update_note').val();

                $.ajax({
                    url: "/schedules/" + id,
                    method: "put",
                    data: {
                        id: id,
                        date: date,
                        time_from: time_from,
                        time_to: time_to,
                        status: status,
                        category_id: category_id,
                        note: note,
                    }
                }).done(function (data) {
                    $('#modal_' + id).modal('toggle');
                    var b = [];
                    var col = chooseColor(data.status);
                    b.push({
                        id: data.id,
                        title: 'KH: ' + data.customer.full_name + ', SĐT: ' + data.customer.phone + ' Lưu ý: ' + data.note,
                        description: data.note,
                        start: data.date + 'T' + data.time_from + ':00',
                        end: data.date + 'T' + data.time_to + ':00',
                        color: col,
                        //data bonus
                        note: data.note,
                        full_name: data.customer.full_name,
                        phone: data.customer.phone,
                        creator_id: data.creator_id,
                        time_from: data.time_from,
                        time_to: data.time_to,
                        category_id: data.category_id,
                        date: formatYMDtoDMY(data.date),
                        status: data.status,
                    })
                    $('#calendar1').fullCalendar('removeEvents', [id]);
                    $('#calendar1').fullCalendar('addEventSource', b);
                    console.log(data);
                })
            })

            function chooseColor(status) {
                if (status == 1)
                    return '#63cff9'
                else if (status == 2)
                    return '#dccf34'
                else if (status == 3)
                    return '#d03636'
                else if (status == 4)
                    return '#4bcc4b'
                else if (status == 5)
                    return '#808080'
                else
                    return ''

            }
        });

    </script>

@endsection
