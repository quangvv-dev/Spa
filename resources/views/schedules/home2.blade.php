@extends('layout.app')

<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}' rel='stylesheet'/>
<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}' rel='stylesheet' media='print'/>
<style>
    .container {
        max-width: 90% !important;
    }

    .content-custom {
        max-width: 100% !important;
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

    thead > tr th {
        background: #fff !important;
    }

</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header row">
                {{--<div class="col-md-6">--}}
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
                <div class="col">
                    {!! Form::text('date', null, array('class' => 'form-control','id'=>'search','autocomplete'=>'off','data-toggle'=>'datepicker','placeholder'=>'Ngày hẹn')) !!}
                </div>
                <div class="col">
                    {!! Form::select('person_action',@$staff2, $user, array( 'id'=>'person_action','class' => 'form-control','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                </div>
                <div class="col">
                    {!! Form::text('customer_plus', $customer, array( 'id'=>'customer_plus','class' => 'form-control','placeholder'=>'SĐT khách hàng')) !!}
                </div>
                <div class="col">
                    {!! Form::select('status', $status,null, array( 'id'=>'status','class' => 'form-control','placeholder'=>'Nguồn')) !!}
                </div>
                <div class="col">
                    {!! Form::select('branch_id', $branchs,\Illuminate\Support\Facades\Auth::user()->branch_id?:1, array( 'id'=>'branch_id','class' => 'form-control','placeholder'=>'T.cả chi nhánh')) !!}
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
                // $('#calendar1').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

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
                let status = $('#status').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({search: arr, status: status, date: date, user: user, customer: customer});
            });
            $(document).on('change', '#search', function () {
                $('.spin').show();
                var val = $(this).val();
                let status = $('#status').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                let branch_id = $('#branch_id').val();
                searchAjax({
                    date: val,
                    branch_id: branch_id,
                    status: status,
                    search: arr,
                    user: user,
                    customer: customer
                });
            });
            $(document).on('change', '#status', function () {
                $('.spin').show();
                var val = $(this).val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                let branch_id = $('#branch_id').val();

                searchAjax({
                    status: val,
                    branch_id: branch_id,
                    date: date,
                    search: arr,
                    user: user,
                    customer: customer
                });
            });
            $(document).on('change', '#person_action', function () {
                var val = $(this).val();
                let status = $('#status').val();
                let date = $('#search').val();
                let customer = $('#customer_plus').val();
                let branch_id = $('#branch_id').val();

                searchAjax({
                    user: val,
                    branch_id: branch_id,
                    status: status,
                    date: date,
                    search: arr,
                    customer: customer
                });

            });
            $(document).on('change', '#customer_plus', function () {
                var val = $(this).val();
                let status = $('#status').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let branch_id = $('#branch_id').val();
                searchAjax({customer: val, branch_id: branch_id, status: status, user: user, date: date, search: arr});

            });

            $(document).on('change', '#branch_id', function () {
                let branch_id = $(this).val();
                let status = $('#status').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({
                    customer: customer,
                    branch_id: branch_id,
                    status: status,
                    user: user,
                    date: date,
                    search: arr
                });

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

            $('body').on('click', 'button.fc-prev-button, button.fc-next-button', function () {
                let moment = $('#calendar1').fullCalendar('getDate');
                let calDate = moment.format('YYYY-MM-DD'); //Here you can format your D
                let month = new Date(moment).getMonth() + 1;
                month = month < 10 ? '0' + month : month;
                let year = new Date(moment).getFullYear();
                let endDate = `${year}-${month}-31`;

                let status = $('#status').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                let branch_id = $('#branch_id').val();
                let date = $('#search').val();

                searchAjax({
                    customer: customer,
                    branch_id: branch_id,
                    status: status,
                    user: user,
                    date: date,
                    search: arr,
                    start_date: calDate,
                    end_date: endDate,
                });
            });


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
