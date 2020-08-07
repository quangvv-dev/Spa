@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div class="card-header">
                <div class="col-md-4 col-sm-6">
                    {!! Form::select('campaign_id', $campaigns, null, array('class' => 'form-control campaign', 'placeholder' => 'Tất cả chiến dịch')) !!}
                </div>
            </div>
            <div id="registration-form">
                @include('post.ajax_customer')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        function searchCategory(data) {
            $.ajax({
                url: "{{ Url('customer-post/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }

        $(document).on('change', '.campaign', function () {
            const id = $(this).val();
            const data = {campaign_id: id};

            searchCategory(data)
        });
        // $('.coppy').click(function () {
        //     $('#slug').focus();
        //     $('#slug').select();
        //     document.execCommand('copy');
        // })
    </script>
@endsection
