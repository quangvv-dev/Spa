@extends('layout.app')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/app.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chat-application.css')}}">
<style>
    body{
        overflow: hidden !important;
    }
</style>
@section('content')
    <div  id="vue-component" class="chat-application">
        <chat-component></chat-component>
    </div>
@endsection
@section('vuejs')
    <script src="{{ asset('js/app.js') }}" defer type="text/javascript"></script>
@endsection