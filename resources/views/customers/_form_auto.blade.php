@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3>
            </div>
            {!! Form::open(array('url' => route('customers.storeGroup'), 'method' => 'post', 'files'=> true, 'id'=>'fvalidate','autocomplete'=>'off')) !!}
            <div class="col">
                <div class="table-responsive">
                    <table class="table card-table table-bordered table-vcenter text-nowrap table-primary">
                        <thead style="width: 100%" class="text-white">
                        <tr>
                            <th class="text-white text-center">Tên KH</th>
                            <th class="text-white text-center">SĐT</th>
                            <th class="text-white text-center">Giới tính</th>
                            <th class="text-white text-center">link FB</th>
                            <th class="text-white text-center">Nhóm KH</th>
                            <th class="text-white text-center">Nguồn KH</th>
                            <th class="text-white text-center">Người phụ trách</th>
                        </tr>
                        </thead>
                        <tbody class="order">

                        </tbody>
                    </table>
                    <div class="col bot">
                        <a href="javascript:void(0)" id="add_row" class="red">(+) Thêm khách hàng</a>
                    </div>
                </div>

            </div>
            <div class="col" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{route('customers.index')}}" class="btn btn-danger">Trở lại</a>
            </div>
            {{ Form::close() }}
            <input type="hidden" id="phone_hidden" >

        </div>
    </div>
@endsection
@section('_script')
    <script>
        var arr = [{{implode($sale,',')}}];
        var max = {{count($sale)}};
        var arr_name = [{!! $sale_name !!}];
        $(document).on('click', '#add_row', function () {
            var rowCount = $('.order tr').length;
            if (rowCount >= max) {
                let per = Number(Math.floor(rowCount / max));
                rowCount = rowCount - max * per;
            }
            $('.order').append(`
                <tr>
         <td>{!! Form::text('full_name[]', null, array('class' => 'form-control quantity', 'required' => true)) !!}
         <td>{!! Form::text('phone[]', null, array('class' => 'form-control phone', 'required' => true)) !!}
            <span id="phone[]-error" class="help-block err_phone"></span>
            </td>
         <td class="text-center">
            {!! Form::select('gender[]',[0 => 'Nữ', 1 => 'Nam'], null, array('class' => 'form-control','required'=>true, 'placeholder' => 'Giới tính')) !!}
            </td>
            <td>{!! Form::text('facebook[]', null, array('id' => 'facebook','class' => 'form-control')) !!}</td>
            <td>
            <select name="group_id[` + rowCount + `][]" required class="form-control select2" multiple data-placeholder="Nhóm khách hàng">
            @foreach($group as $k => $item)
            <option value='{{$k}}' >{{$item}}</option>
                @endforeach
            </select>
            </td>
            <td class="text-center">
            {!! Form::select('source_id[]', $source, null, array('class' => 'form-control select2','required'=>true, 'data-placeholder' => 'Nguồn khách hàng')) !!}
            </td>
            <td>
            <select name="telesales_id[]" class="form-control" >
                <option value=` + arr[rowCount] + ` >` + arr_name[rowCount] + `</option>
            </select>
            </td>
            <td class="tc vertical-middle remove_row"><button class='btn btn-danger'>X</button></td>
        </tr>`);
            $('.select2').select2({ //apply select2 to my element
                placeholder: "-Chọn sản phẩm-",
                allowClear: true
            });
        });

        $('.order').delegate('.phone', 'change', function () {
            let target = $(this).val();
            $('#phone_hidden').val(target);
            $.ajax({
                url: "{{ url('api/check-unique-customers') }}",
                method: "post",
                data: {phone: target}
            }).done(function (data) {
                if(data=='false'){
                    $('.err_phone').html('Số điện thoại đã tồn tại trong hệ thống');
                }else{
                    $('.err_phone').html('').change();
                }
            });
        });

        $(document).on('click', '.remove_row', function (e) {
            $(e.target).parent().parent().remove();
        });
        $(document).on('click', '.add_note', function (e) {
            const clicks = $(this).data('clicks');
            const target = $(e.target).parent().parent();

            if (clicks) {
                $(target).find('.product_note').css({'display': 'none'});
            } else {
                $(target).find('.product_note').css({'display': 'block'});
            }
            $(this).data("clicks", !clicks);
        })

    </script>
    <script>
        $(document).ready(function () {
            // validate phone
            jQuery.validator.addMethod("phone", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length > 9 &&
                    phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/);
            }, "Số điện thoại không hợp lệ");

            $("#fvalidate").validate({
                rules: {
                    full_name: {
                        required: true,
                        normalizer: function (value) {
                            return $.trim(value);
                        }
                    },
                    phone: {
                        required: true,
                        remote: {
                            url: "{{ url('api/check-unique-customers') }}",
                            type: "post",
                            data: {
                                phone: function () {
                                    return $('#phone_hidden').val();
                                }
                            },
                        }
                    },
                    gender: {
                        required: true
                    },
                    group_id: {
                        required: true
                    },
                    source_id: {
                        required: true
                    },
                    telesales_id: {
                        required: true
                    }
                },
                messages: {
                    full_name: "Chưa nhập tên",
                    phone: {
                        required: "Chưa nhập số điện thoại",
                        remote: "Số điện thoại đã tồn tại trong hệ thống",
                    },
                    gender: "Chưa chọn giới tính",
                    status_id: "Chưa chọn trạng thái",
                    group_id: "Chưa chọn nhóm khách hàng",
                    source_id: "Chưa chọn nguồn khách hàng",
                    telesales_id: "Chưa chọn người phụ trách",
                },
            });
        });
    </script>
@endsection
