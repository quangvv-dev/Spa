<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="">
    <title>RoyalSpa</title>
    <script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Alertify -->
</head>
<body style="overflow: hidden">

<div class="">
    @if(isset($post->form_html))
        {!! $post->form_html !!}
    @endif
</div>
<script crossorigin="*">
    $(document).on('click', '.btn.form-control', function (e) {
        let ids = {{$post->id}};
        let form = $('form');
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
                    alertify.success(data);
                }

            }
        })
    })
</script>
</body>
</html>
