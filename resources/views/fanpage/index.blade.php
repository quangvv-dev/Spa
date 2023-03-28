@extends('layout.app')
@section('content')
    <style>
        .page-header {
            display: none;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <a style="color: #ffffff" class="right btn btn-primary btn-flat" data-toggle="modal"
           data-target="#myModal"><i class="fa fa-plus-circle"></i>Thêm mới khách hàng</a>
        <div class="card">
            <div id="registration-form">
                <iframe id="frameDemo" width="100%" height="950px"
                        src="https://smax.in/#/?returnUrl=%2Ffbpage"></iframe>
            </div>
            @include('fanpage.modal')
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            // validate phone
            jQuery.validator.addMethod("phone_number", function (phone_number, element) {
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
                                    return $("#phone").val();
                                },
                                id: {{ isset($customer) ? $customer->id : 0 }},
                            },
                        }
                    },
                    gender: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                    status_id: {
                        required: true
                    },
                    'group_id[]': {
                        required: true
                    },
                    source_id: {
                        required: true
                    },
                },
                messages: {
                    full_name: "Chưa nhập tên",
                    phone: {
                        required: "Chưa nhập số điện thoại",
                        remote: "Số điện thoại đã tồn tại trong hệ thống",
                    },
                    gender: "Chưa chọn giới tính",
                    status_id: "Chưa chọn trạng thái",
                    'group_id[]': "Chưa chọn nhóm khách hàng",
                    source_id: "Chưa chọn nguồn khách hàng",
                },
            });
        });
    </script>

@endsection
