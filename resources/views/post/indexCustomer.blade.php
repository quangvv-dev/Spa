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
                @if(\Illuminate\Support\Facades\Auth::user()->role != \App\Constants\UserConstant::TELESALES)
                    <div class="col-md-3 col-sm-6">
                        {!! Form::select('telesales', $telesales, null, array('class' => 'form-control sales select-gear','placeholder'=>'Tất cả sales')) !!}
                    </div>
                @endif
                <div class="col-md-2 col-sm-6">
                    {!! Form::select('status', $status, null, array('class' => 'form-control select-gear status','placeholder'=>'Trạng thái')) !!}
                </div>
                <div class="col-md-6 col-sm-6">
                    {!! Form::select('campaign_id', $campaigns, null, array('class' => 'form-control campaign select-gear', 'placeholder' => 'Tất cả chiến dịch')) !!}
                </div>
                <div class="col-md-1 col-sm-6">
                    <a title="Download Data" class="btn export" href="#">
                        <i class="fas fa-download"></i></a>
                </div>
            </div>
            <div id="registration-form">
                @include('post.ajax_customer')
                @include('post.modal-update-account')
            </div>
            <input type="hidden" id="campaign_id">
            <input type="hidden" id="status_id">
            <input type="hidden" id="telesales_id">
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"
            integrity="sha512-F7O0WjUWT+8qVnkKNDeXPt+uwW51fA8QLbqEYiyZfyG8cR0oaodl2oOFWODnV3zZvcy0IruaTosDiSDSeS9LIA=="
            crossorigin="anonymous"></script>t>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select-gear').selectize({
                sortField: 'text'
            });
            //     $(".fc-datepicker").datepicker({dateFormat: 'dd-mm-yy'});
        });

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
            // const opt = document.querySelector('.campaign option:checked');
            $('#campaign_id').val(id);
            const status = $('#status_id').val();
            const sales = $('#telesales_id').val();
            searchCategory({campaign_id: id, status: status, telesales_id: sales})
        });
        $(document).on('change', '.sales', function (e) {
            const id = $(this).val();
            $('#telesales_id').val(id);
            const status = $('#status_id').val();
            const campaign_id = $('#campaign_id').val();
            searchCategory({campaign_id: campaign_id, status: status, telesales_id: id})
        });
        $(document).on('change', '.status', function (e) {
            const id = $(this).val();
            $('#status_id').val(id);
            const campaign_id = $('#campaign_id').val();
            const sales = $('#telesales_id').val();
            searchCategory({campaign_id: campaign_id, status: id, telesales_id: sales})
        });

        $(document).on('click', '.export', function () {
            const status = $('#status_id').val();
            const campaign_id = $('#campaign_id').val();
            const sales = $('#telesales_id').val();
            var opts = document.querySelector('.campaign option:checked').text;
            var hrefs = "{{ route('customer_post.export') }}?campaign_id=" + campaign_id + '&status=' + status + '&telesales_id=' + sales + '&campaign=' + opts;
            location.href = hrefs;
        });

        @if(\Illuminate\Support\Facades\Auth::user()->role != \App\Constants\UserConstant::TELESALES)
        $(document).on('dblclick', '.telesale-customer', function (e) {
            let target = $(e.target).parent();
            $(target).find('.telesale-customer').empty();
            let id = $(this).data('customer-id');
            let html = '';

            $.ajax({
                url: "{{route('customer_post.find')}}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                html +=
                    '<select class="telesales-result form-control select2" data-id="' + data.customer.id + '" name="telesale_id" style="font-size: 14px;">';
                data.data.forEach(function (item) {
                    html +=
                        '<option value="' + item.id + '" ' + (item.id === data.customer.telesales_id ? "selected" : "") + '>' + item.full_name + '</option>';
                });

                html += '</select>';

                $(target).find(".telesale-customer").append(html);
            });
        });
        @endif

        $(document).on('change', '.telesales-result', function (e) {
            let target = $(e.target).parent();
            const telesales_id = $(target).find('.telesales-result').val();
            let id = $(this).data('id');

            $.ajax({
                url: "{{route('customer_post.update')}}",
                method: "put",
                data: {
                    ids: [id],
                    telesales_id: telesales_id,
                }
            }).done(function (data) {
                $(target).parent().find(".telesale-customer").html(data);
            });
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
