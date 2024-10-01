@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('promotions.create') }}"><i
                            class="fa fa-plus-circle"></i> Tạo mới</a></div>
            </div>
            {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
            <div class="card-header">
                <input class="form-control name col-md-2" name="search" placeholder="Tìm kiếm" tabindex="1"
                       type="search">
                <div class="col-md-2" style="font-size: 16px;">
                    {!! Form::select('type', $type, null, array('class' => 'form-control type','data-placeholder'=>'Loại voucher')) !!}
                </div>
            </div>
            {{Form::close()}}
            <div id="registration-form">
                @include('promotions.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('change', '.type, .name', function () {
            $('#gridForm').submit();
        });
    </script>
@endsection
