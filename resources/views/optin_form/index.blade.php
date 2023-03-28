<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="">
    <title>RoyalSpa</title>
    <script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
    <!-- Alertify -->
</head>
<style>
    .error{
        color: red;
        font-size: 11px;
        border-color: red;
    }
    input {
        height: 38px !important;
    }
    button {
        height: 33.5px !important;
    }
    textarea.form-control {
        height: 118.625px;
    }
    /*h2, .h2 {*/
        /*font-size: 1.75rem;*/
    /*}*/
</style>
<body style="overflow: hidden">

<div class="">
    @if(isset($post->form_html))
        {!! $post->form_html !!}
    @endif
</div>
<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/js/additional-methods.min.js')}}"></script>
<script crossorigin="*">

    $(document).on('click', '.btn.form-control', function (e) {
        let form = $('form');
        if (form.valid()) {
            let ids = {{$post->id}};
            let full_name = form.find("input[name='full_name']").val();
            let phone = form.find("input[name='phone']").val();
            let email = form.find("input[name='email']").val();
            let textarea = form.find("textarea[name='content']").val();
            let button = $(this);
            e.preventDefault();
            $.ajax({
                url: location.origin + '/customer-post',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    full_name: full_name,
                    email: email,
                    phone: phone,
                    note: textarea,
                    id: ids
                },
                success: function (data) {
                    button.attr('disabled', true);
                    if (button.prop('tagName').toLowerCase() === 'input') {
                        button.val('Đăng ký thành công');
                    } else {
                        button.text('Đăng ký thành công');
                        // alertify.success(data);
                    }

                }
            })
        } else {
            return false;
        }
    })
</script>
<script>
    $().ready(function () {
        $("form").validate({
            onsubmit: true,
            rules: {
                full_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    minlength: 10,
                    number: true
                }
            },
            messages: {
                full_name: {
                    required: "Vui lòng nhập họ tên"
                },
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email chưa đúng định dạng"
                },
                phone: {
                    required: "Vui lòng nhập số điện thoại",
                    minlength: "Vui lòng nhập lớn hơn 10 ký tự",
                }
            }
        });
    })
</script>
</body>
</html>
