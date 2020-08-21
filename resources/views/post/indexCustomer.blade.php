@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div class="card-header">
                <div class="display btn-group" id="btn_tool_group" style="display: none">
                    <button type="button" class="btn btn-default position dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"> Thao tác <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li class="dropdown_action" id="show_manager_account"><a>Người phụ trách</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-6">
                    {!! Form::select('campaign_id', $campaigns, null, array('class' => 'form-control campaign', 'placeholder' => 'Tất cả chiến dịch')) !!}
                </div>
                <div class="col-md-3 col-sm-6">
                    {!! Form::select('telesales', $telesales, null, array('class' => 'form-control','placeholder'=>'Tất cả sales')) !!}
                </div>
            </div>
            <div id="registration-form">
                @include('post.ajax_customer')
                @include('post.modal-update-account')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        function searchCategory(data) {
            $.ajax({
                url: "{{ Url('customer-post/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }

        $(document).on('change', '.campaign', function (e) {
            const id = $(this).val();
            const opt = document.querySelector('.campaign option:checked');
            const data = {campaign_id: id};
            searchCategory(data)
        });

        $(document).on('click', '.selectall', function () {
            if ($(this).hasClass('active')) {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
                $(this).html('Chọn tất cả');
                $(this).removeClass('active');

            } else {
                $(this).addClass('active');
                $(':checkbox').each(function () {
                    this.checked = true;
                });
                $(this).html('Bỏ chọn tất cả');
            }
        });

        $(document).on('click', '.myCheck', function () {
            if ($(this).is(':checked'))
                $("#btn_tool_group").css({'display': 'block'});
            else
                $("#btn_tool_group").css({'display': 'none'});
        });
        $(document).on('click', '#show_manager_account', function () {
            $('#show-manager-account').modal("show");
        });
        var ids = [];
        $(document).on('click', '.update-multiple-account-manager', function () {
            const id = $('td .myCheck:checked');
            const account_manager = $('#manager-account').val();
            $.each(id, function () {
                ids.push($(this).val());
            });

            $.ajax({
                url: "{{route('customer_post.update')}}",
                method: "put",
                data: {
                    ids: ids,
                    telesales_id: account_manager,
                }
            }).done(function () {
                window.location.reload();
            });
        });
        $('.update-status').click(function () {
            const id = $(this).data('id');

            swal({
                title: 'Bạn đã gọi điện CSKH ?',
                type: "success",
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'Đồng ý',
                CancelButtonText: 'Từ chối',
                showCancelButton: true,
            }, function () {
                $.ajax({
                    type: 'PUT',
                    url: "{{route('customer_post.update')}}",
                    data: {
                        ids: [id],
                        status: 1,
                    },
                    success: function () {
                        window.location.reload();
                    }
                })
            })
        });
        // $('.coppy').click(function () {
        //     $('#slug').focus();
        //     $('#slug').select();
        //     document.execCommand('copy');
        // })
    </script>
@endsection
