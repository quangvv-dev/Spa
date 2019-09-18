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
        $('iframe').load(function () {
            $('iframe').contents().find("head")
                .append($("<style type='text/css'>.menu2.hidden-sm.hidden-xs {display: none !important;}a.logo img {display: none !important;}  </style>"));
        });
    </script>
@endsection
