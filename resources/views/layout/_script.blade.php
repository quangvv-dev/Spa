<script>
    $('document').ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#gridForm").submit(function (e, page) {
            $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.get($(this).attr('action'), $(this).serialize(), function (data) {
                $('#registration-form').html(data);
            });
            return false;
        });
        $('.angleDoubleUp').on('click', function () {
            $('.isShowView').hide();
            $('.angleDoubleDown').show();
            $(this).hide();
        });
        $('.angleDoubleDown').on('click', function () {
            console.log(11111);
            $('.isShowView').show();
            $('.angleDoubleUp').show();
            $(this).hide();
        });
        // delete action
        $(document).on('click', '.delete', function (e) {
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

        //thông báo

        var x = document.getElementById("myAudio");

        function playAudio() {
            x.play();
        }

        $.ajax({
            type: 'GET',
            url: '/ajax/count-notifications',
            data: {
                user_id:{{\Illuminate\Support\Facades\Auth::user()->id}}
            },
            success: function (data) {
                if (data) {
                    var row = $('body').find('.badge.badge-danger.badge-pill');
                    var row2 = $('body').find('.dropdown-item.text-center.text-dark');
                    row.html(data);
                    row2.html(data + ' thông báo mới');
                    $('#check_notify').val(data);
                }
            }
        })

        $('body').delegate('.detail-timeline', 'click', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: '/admin/ajax/change-notification/' + id,
                // timeout: 3000,//60 second timeout
                success: function (data) {
                    if (data) {
                        window.location.href = url;
                    }
                }
            })
        })

        $('#btn_audio').click(function () {
            playAudio();
        });

        var callAjax = function () {

            var check = $('#check_notify').val();
            $.ajax({
                type: 'GET',
                url: '/ajax/count-notifications',
                // timeout: 3000,//60 second timeout
                data: {
                    user_id:{{\Illuminate\Support\Facades\Auth::user()->id}}
                },
                success: function (data) {
                    if (data) {
                        var row = $('body').find('.badge.badge-danger.badge-pill');
                        var row2 = $('body').find('.dropdown-item.text-center.text-dark');
                        row2.html(data + ' Thông báo mới');
                        row.html(data);
                        // console.log(data, check,'so sanh');
                        if (data != check) {
                            $('#btn_audio').click();
                            $('#check_notify').val(data);
                        } else {
                            $('#check_notify').val(data);
                        }
                    }
                }
            })
        }
        setInterval(callAjax, 60000);

        $('.notification').click(function () {
            $.ajax({
                type: 'GET',
                url: '/ajax/notifications',
                // timeout: 60000,//60 second timeout
                data: {
                    user_id:{{\Illuminate\Support\Facades\Auth::user()->id}}
                },
                success: function (data) {
                    if (data) {
                        var row = $('body').find('.content-notify');
                        var html = '';
                        $.each(data, function (i, v) {
                            console.log(v.data.task_id,'data list');
                            var obj = v.data;

                            if(v.type == 3){
                                var type = '/thu-chi?id='+ obj.pay_id;
                            } else {
                                var type = '/tasks/' + obj.task_id + '/edit';
                            }

                            if (v.status == {{\App\Constants\NotificationConstant::UNREAD}}) {
                                var color = '#edf2fa';
                                var boder = 'red';
                            }
                            if (v.status == {{\App\Constants\NotificationConstant::READ}}) {
                                var color = '#ffffff';
                                var boder = 'green';
                            }

                            html += '<a class="dropdown-item d-flex pb-3 tag-click" href="javascript:void(0)" data-id="' + v.id + '" data-url="' + type + '" style="background:' + color + '"><div class="text-notification">' + v.title + '<div class="small text-muted">' + v.created_at + '</div></div></a>';
                            row.html(html);
                        });
                    }
                }
            })
        })

        $('body').delegate('.tag-click', 'click', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            console.log(id, url);
            $.ajax({
                type: 'GET',
                url: '/ajax/change-notification/' + id,
                success: function (data) {
                    window.location.href = url;
                }
            })
        });
        //end thông báo
    }).ajaxStart(function () {
        $('.load').show();
    }).ajaxStop(function () {
        $('.load').hide();
    });
</script>
