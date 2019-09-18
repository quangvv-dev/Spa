@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div id="registration-form">
                <iframe width="100%" height="950px" src="https://smax.in/#/?returnUrl=%2Ffbpage"></iframe>
                <style>
                    .page-header {
                        display: none;
                    }
                </style>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(window).bind("load", function () {
            $('iframe.menu2.hidden-sm.hidden-xs').addClass('display', 'none');
            $('iframe a.logo img').addClass('display', 'none');
            $('iframe a[href^="#/user"]').each(function () {
                var oldUrl = $(this).attr("href"); // Get current url
                console.log(oldUrl);
                if (oldUrl == '#/user') {
                    var newUrl = '#'; // Create new url
                    $(this).attr("href", newUrl).trigger('change'); // Set herf value
                }
            });
        });
        // $('.dropdown-menu.dropdown-avatar h4 a')
    </script>
@endsection
