@extends('layout.app')
@section('content')
    <style>
        .page-header {
            display: none;
        }

        /*.menu2.hidden-sm.hidden-xs {display: none !important;}*/

        a.logo img {
            display: none !important;
        }

        /*nav.menu2.hidden-sm.hidden-xs {*/
        /*    display: none;*/
        /*}*/
    </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                var iframe = document.getElementById("frameDemo");
                var elmnt = iframe.contentWindow.document.getElementsByClassName("menu2")[0];
                $(elmnt).css('display', 'none');
            }, 3000);
        });
    </script>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div id="registration-form">
                <iframe id="frameDemo" width="100%" height="950px"
                        src="https://smax.in/#/?returnUrl=%2Ffbpage"></iframe>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')

@endsection
