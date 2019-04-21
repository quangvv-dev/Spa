<script>
    $('document').ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // delete action
        $('.delete').click(function () {
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
                        window.location.reload();
                    }
                })
            })

        });
    }).ajaxStart(function () {
        $('#loading').show();
    }).ajaxStop(function () {
        $('#loading').hide();
    });
</script>
