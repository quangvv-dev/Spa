@extends('layout.app')
@section('_style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link href="{{ asset('css/order-search.css') }}" rel="stylesheet"/>
    <style>

        .form-control {
            font-size: 14px;
        }

        .table th, .text-wrap table th {
            text-transform: unset;
            color: white;
        }

        tr.number_index th {
            font-size: 12px;
        }

        th.text-center {
            font-size: 13px;
        }

        tr.fixed th {
            font-size: 12px;
        }

        .budget, .comment, .message {
            width: 105px;
        }
    </style>

@endsection
@section('content')

    <div class="col-md-12">
        <div id="fix-scroll" class="row padding mb10 header-card border-bot shadow">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title bold">Doanh thu Marketing</h3>
                </div>

                <div class="card-header row">

                    {!! Form::open(array('url' => url()->current(), 'method' => 'get','class'=>'col-lg-12', 'id'=> 'gridForm','role'=>'form')) !!}

                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input id="reportrange" type="text" class="form-control square">
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                            <div class="col-md-2">
                                <select name="branch_id" id="branch_id" class="form-control">
                                    <option value="">Tất cả chi nhánh</option>
                                    @foreach($branchs as $k=> $item)
                                        <option value="{{$k}}">{{ $item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                            </div>
                        @endif
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary"> Tìm kiếm
                            </button>
                        </div>
                        <div class="col-2 text-right">
                            <button class="btn btn-success btnThemLandingData">Thêm mới</button>
                        </div>
                        {{--<a title="Download Data" class="btn download-pdf"--}}
                        {{--href="javascript:void(0)">--}}
                        {{--<i class="fas fa-download"></i></a>--}}
                    </div>
                    {{ Form::close() }}

                </div>
                <div class="col-md-12 col-lg-12">
                    @include('marketing.dashbroad.ajax')
                </div>
                @include('marketing.dashbroad.modal')

            </div>
        </div>
    </div>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script src="{{ asset('js/format-number.js') }}"></script>

    <script>
        // show modal
        let array_delete = [];
        $(document).on('click', '.btnThemLandingData', function (e) {
            e.preventDefault();
            $('.list-data').html('');
            resetData();
            $('#exampleModal').modal('show');
        })

        $(document).on('click', '#add_new_price_marketing', function () {
            $('.list-data').append(
                `<tr>
                        <input type="hidden" name="id[]" value="">
                        <td><input type="text" class="txt-dotted form-control budget" name="budget[]"></td>
                        <td><input type="text" class="txt-dotted form-control data" name="data[]"></td>
                        <td><input type="text" class="txt-dotted form-control invoice" name="invoice[]"></td>
                        <td><input type='text' name="date[]" id="datepicker" data-toggle="datepicker" class="form-control"/></td>
                        <td>
                            <a href="javascript:void(0)" class="delete-item" data-id=""><i class="fa fa-trash fa-2x"></i></a>
                        </td>
                    </tr>
                `
            )
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        })

        $(document).on('keyup', '.budget,.data,.invoice', function () {
            $(this).val(formatNumber($(this).val()))
        })
        $(document).on('click', '.searchAddLanding', function (e) {
            e.preventDefault();
            resetData();
            let html = '';
            $.ajax({
                type: "get",
                data: {
                    start_date: $('#exampleModal #start_date1').val(),
                    end_date: $('#exampleModal #end_date1').val()
                },
                url: '/ajax/marketing/search-price-marketing',
                success: function (data) {
                    if (data.length > 0) {
                        data.forEach((el, i) => {
                            html += `
                                <tr>
                                    <input type="hidden" name="id[]" value="` + el.id + `">
                                    <input type="hidden" name="date[]" value="` + el.date + `">
                                    <td><input type="text" class="txt-dotted budget number" name="budget[]" value="` + formatNumber(el.budget) + `"></td>
                                    <td><input type="text" class="txt-dotted data number" name="data[]" value="` + formatNumber(el.data) + `"></td>
                                    <td><input type="text" class="txt-dotted invoice number" name="invoice[]" value="` + formatNumber(el.invoice) + `"></td>
                                    <td>` + el.date + `</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="delete-item" data-id="` + el.id + `"><i class="fa fa-trash fa-2x"></i></a>
                                    </td>
                                </tr>
                            `
                            $('.list-data').html(html);
                        });
                    } else {
                        $('.list-data').html('');
                    }
                }
            })
        })

        $(document).on('click', '.delete-item', function (e) {
            let parent = $(e.target).closest('tr');
            let id = $(this).data('id');
            swal({
                title: 'Bạn có muốn xóa ?',
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'OK'
            }, function () {
                if (id) {
                    array_delete.push(id);
                    let data_delete = JSON.stringify(array_delete);
                    $('#exampleModal .array_delete').val(data_delete);
                }
                $(parent).remove();
            })
        });

        function resetData() {
            array_delete = [];
            $('#exampleModal .array_delete').val('');
        }

    </script>
@endsection

