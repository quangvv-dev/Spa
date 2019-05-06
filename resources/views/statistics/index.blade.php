@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('status.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <div class="wd-200 mg-b-30">
                    <div class="input-group">
                        {!! Form::text('from_date', null, array('id' => 'from-date', 'class' => 'form-control fc-datepicker', 'placeholder' => 'Từ ngày')) !!}
                    </div>
                </div>
                <div class="wd-200 mg-b-30" style="margin-left: 5px">
                    <div class="input-group">
                        {!! Form::text('to_date', null, array('id' => 'to-date', 'class' => 'form-control fc-datepicker', 'placeholder' => 'Đến ngày')) !!}
                    </div>
                </div>
            </div>

            <div id="registration-form">
                @include('statistics.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('keyup change', '#from-date,#to-date', function (e) {
            e.preventDefault();
            var from_date = $('#from-date').val();
            var to_date = $('#to-date').val();

            $.ajax({
                url: "{{ Url('statistics/') }}",
                method: "get",
                data: {
                    from_date: from_date,
                    to_date: to_date
                }
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
