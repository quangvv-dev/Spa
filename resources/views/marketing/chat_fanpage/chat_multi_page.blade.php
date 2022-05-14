@extends('layout.app')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chat-application.css')}}">
@section('content')
    <div class="" id="vue-component">
        <chat-multi-component></chat-multi-component>
    </div>
    </div>
@endsection
@section('vuejs')
    <script src="{{ asset('js/app.js') }}" defer type="text/javascript"></script>
@endsection