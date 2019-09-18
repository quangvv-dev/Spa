@extends('layout.app')
@section('content')
    <style>
        .page-header {
            display: none;
        }
        nav.menu2.hidden-sm.hidden-xs{
            display: none;
        }
        a.logo img {
            display: none;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div id="registration-form">
                <iframe width="100%" height="950px" src="https://smax.in/#/?returnUrl=%2Ffbpage"></iframe>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function(){
            $('a[href^="http://"]').each(function(){
                var oldUrl = $(this).attr("href"); // Get current url
                if (oldUrl=='#/user'){
                    var newUrl = '#'; // Create new url
                    $(this).attr("href", newUrl).trigger('change'); // Set herf value
                }
            });
        });
        // $('.dropdown-menu.dropdown-avatar h4 a')
    </script>
@endsection
