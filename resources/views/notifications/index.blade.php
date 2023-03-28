@extends('layout.app')
@section('content')
    <style>
        .date {
            font-size: 11px;
            color: gray;
        }
        td{
            cursor: pointer;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông báo của bạn</h3>
            </div>
            <div id="registration-form">
                @include('notifications.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $('body').delegate('td', 'click', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: '/ajax/change-notification/' + id,
                success: function (data) {
                    window.location.href = url;
                }
            })
        });
    </script>
@endsection
