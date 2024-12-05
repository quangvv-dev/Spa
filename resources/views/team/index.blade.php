@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thêm mới thông tin đội, nhóm</h3>
                </br>
            </div>
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tên nhóm…" tabindex="1" type="text" id="search" value="">
            </div>
            <div id="registration-form">
                @include('team.ajax')
            </div>
            @include('team._form')
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript" src="{{asset('js/custom/teams.js')}}"></script>
@endsection
