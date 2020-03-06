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
</style>
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-left: 6%">
        <div class="card">
            <div class="card-header">
                <div class="left-click" style="position: absolute;
                                            display: flex;
                                            flex-direction: column;
                                            left: -12.5%;
                                            top: 2%;">
                    @foreach($color as $k => $item)
                        <div class="btn white account_relation position"
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
                            <label for="{{$k}}">{{$item}}</label>
                        </div>
                    @endforeach
                        <input type="hidden" class="status-val">
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
                                var col = '#f39b4f'
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
                                var col = '#gray'
                                break;
                            default:
                            // code block
                        }
                        b.push({
                            id: value.id,
                            title: 'KH: ' + value.customer.full_name + ', SĐT: ' + value.customer.phone + ' Lưu ý: ' + value.note,
                            description: value.note,
                            start: value.date + 'T' + value.time_from + ':00',
                            end: value.date + 'T' + value.time_to + ':00',
                            color: col,
                        });
                    });
                    $('#calendar1').fullCalendar('removeEvents');
                    $('#calendar1').fullCalendar('addEventSource', b);
                    s
                });
            }

            $('body').delegate('.status', 'click', function () {
                var data = $(this).attr('id');
                var arr = [];
                if (! $(this).is(":checked")) {
                    let defaults = $('.status-val').val();
                    arr.push(defaults);
                    // var trainindIdArray = defaults.replace("[","").replace("]","").split(',');
                    // var filteredAry = trainindIdArray.filter(e => e !== data)
                    console.log(arr,'no check');
                    var training = filteredAry.split(',');
                    console.log(training,'no check');
                } else { // if the checkbox is checked
                    let defaults = $('.status-val').val();
                    var trainindIdArray = data.replace("[","").replace("]","").split(',');
                    var filteredAry = trainindIdArray.filter(e => e !== data)
                    console.log(arr,'check');
                }
                var data = $(this).val();
                var val = $(this).find('.status-val').val();
                $('#status_val').val(val);
                let category = $('#category').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({search: val, category: category, date: date, user: user, customer: customer});
            });
            $(document).on('change', '#search', function () {
                $('.spin').show();
                var val = $(this).val();
                let category = $('#category').val();
                let search = $('#status_val').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({date: val, category: category, search: search, user: user, customer: customer});
            });
            $(document).on('change', '#category', function () {
                $('.spin').show();
                var val = $(this).val();
                let search = $('#status_val').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                let customer = $('#customer_plus').val();
                searchAjax({category: val, date: date, search: search, user: user, customer: customer});
            });
            $(document).on('change', '#person_action', function () {
                var val = $(this).val();
                let category = $('#category').val();
                let search = $('#status_val').val();
                let date = $('#search').val();
                let customer = $('#customer_plus').val();
                searchAjax({user: val, category: category, date: date, search: search, customer: customer});

            });
            $(document).on('change', '#customer_plus', function () {
                var val = $(this).val();
                let category = $('#category').val();
                let search = $('#status_val').val();
                let date = $('#search').val();
                let user = $('#person_action').val();
                searchAjax({customer: val, category: category, user: user, date: date, search: search});

            });

            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd/mm/yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>

@endsection
