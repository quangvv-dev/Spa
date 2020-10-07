@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div id="vue-component">
                <setting-source-component></setting-source-component>
            </div>

        </div>

    </div>
@endsection

@section('vuejs')
    <script src="{{ asset('js/app.js') }}" defer type="text/javascript"></script>

@endsection
@section('_script')
@endsection
