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
                        {{--<div class="col-md-2">--}}
                        {{--{{Form::select('type',[\App\Constants\StatusCode::SERVICE=>'Nhóm dịch vụ',\App\Constants\StatusCode::PRODUCT=>'Nhóm sản phẩm'], @$type, array('class' => 'form-control','id'=>'telesales','placeholder'=>'Chọn loại nhóm'))}}--}}
                        {{--</div>--}}
                        <div class="col-md-2">
                            <select name="branch_id" id="branch_id" class="form-control">
                                <option value="">Tất cả chi nhánh</option>
                                @foreach($branchs as $k=> $item)
                                    <option {{$k==1?'selected':''}} value="{{$k}}">{{ $item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {!! Form::select('location_id', $location, null, array('class' => 'form-control location select-gear', 'placeholder' => 'Cụm khu vực')) !!}
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary"> Tìm kiếm
                            </button>
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
        var source_item = null;
        var name_product = '';
        $(document).on('click', '.btnThemLandingData', function () {
            $('.list-data').html('');
            source_item = $(this).data('item');
            name_product = $(this).data('name_product');
            $('#exampleModal').modal('show');
        })

        $(document).on('click', '#add_new_price_marketing', function () {

            let source = source_item;
            let chanel = source.chanel == 1 ? 'GOOGLE ADS' : source.chanel == 2 ? 'FACEBOOK ADS' : 'ZALO ADS';
            $('.list-data').append(
                `
                            <tr>
                                <input type="hidden" name="source_id" value="` + source.id + `">
                                <input type="hidden" name="branch_id" value="` + source.branch_id + `">
                                <td></td>
                                <td>` + source.name + `</td>
                                <td>` + chanel + `</td>
                                <td>
                                    <input type="text" class="txt-dotted form-control budget" name="budget[]">
                                </td>
                                <td><input type='text' name="date[]" id="datepicker" data-toggle="datepicker" class="form-control"/></td>
                                <td></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="delete-item" data-url="` + chanel + `"><i class="fa fa-trash fa-2x"></i></a>
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

        $(document).on('keyup', '.budget', function () {
            $(this).val(formatNumber($(this).val()))
        })
        $(document).on('click', '.searchAddLanding', function (e) {
            e.preventDefault();
            let source = source_item;
            let html = '';
            $.ajax({
                type: "get",
                data: {
                    start_date: $('.start_date1').val(),
                    end_date: $('.end_date1').val(),
                    source_id: source.id
                },
                url: '/ajax/marketing/search-price-marketing',
                success: function (data) {
                    if (data.length > 0) {
                        data.forEach((el, i) => {
                            let chanel = source.chanel == 1 ? 'GOOGLE ADS' : source.chanel == 2 ? 'FACEBOOK ADS' : 'ZALO ADS'
                            html += `
                                <tr>
                                    <input type="hidden" name="id[]" value="` + el.id + `">
                                    <input type="hidden" name="source_id" value="` + source.id + `">
                                    <input type="hidden" name="date[]" value="` + el.date + `">
                                    <td>` + Number(i + 1) + `</td>
                                    <td>` + source.name + `</td>
                                    <td>` + chanel + `</td>
                                    <td><input type="text" class="txt-dotted budget number" name="budget[]" value="` + formatNumber(el.budget) + `"></td>
                                    <td>` + el.date + `</td>
                                    <td>` + el.user.full_name + `</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="delete-item" data-url="` + window.location.href +'/'+ el.id + `"><i class="fa fa-trash fa-2x"></i></a>
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
            let target = $(e.target).closest('tr');
            var url = $(this).data('url');
            swal({
                title: 'Bạn có muốn xóa ?',
                text: "Nếu bạn xóa tất cả các thông tin sẽ không thể khôi phục!",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'OK'
            }, function () {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _method: 'delete',
                    },
                    success: function () {
                        let target = $(e.target).parent();
                        $(target).remove();
                    }
                })
            })
        });

    </script>
@endsection

