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

    function showLoading() {
        $('.loading-custom').show();
    }
    function hideLoading() {
        $('.loading-custom').hide();
    }

    let array_HOURS = [{
        0:'00:00',
        0.5:'00:30',
        1:'01:00',
        1.5:'01:30',
        2:'02:00',
        2.5:'02:30',
        3:'03:00',
        3.5:'03:30',
        4:'04:00',
        4.5:'04:30',
        5:'05:00',
        5.5:'05:30',
        6:'06:00',
        6.5:'06:30',
        7:'07:00',
        7.5:'07:30',
        8:'08:00',
        8.5:'08:30',
        9:'09:00',
        9.5:'09:30',
        10:'10:00',
        10.5:'10:30',
        11:'11:00',
        11.5:'11:30',
        12:'12:00',
        12.5:'12:30',
        13:'13:00',
        13.5:'13:30',
        14:'14:00',
        14.5:'14:30',
        15:'15:00',
        15.5:'15:30',
        16:'16:00',
        16.5:'16:30',
        17:'17:00',
        17.5:'17:30',
        18:'18:00',
        18.5:'18:30',
        19:'19:00',
        19.5:'19:30',
        20:'20:00',
        20.5:'20:30',
        21:'21:00',
        21.5:'21:30',
        22:'22:00',
        22.5:'22:30',
        23:'23:00',
        23.5:'23:30'
    }]; //còn nợ

    function formatDate(date) {
        date = new Date(date);
        const yyyy = date.getFullYear();
        let mm = date.getMonth() + 1; // Months start at 0!
        let dd = date.getDate();

        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;

        const formattedToday = dd + '/' + mm + '/' + yyyy;
        return formattedToday;
    }
</script>
