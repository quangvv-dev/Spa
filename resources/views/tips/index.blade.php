@extends('layout.app')
<style>
    .table-primary{
        background-color:white !important;
    }
</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DANH SÁCH CÔNG THỦ THUẬT</h3></br>
                <div class="col-2">
                    <a href="{{url('tips-export')}}" data-toggle="tooltip" data-placement="right" title="Tải xuống Excel">
                        <i class="fas fa-download" style="color: dodgerblue"></i></a>
                </div>
            </div>
            @include('tips.ajax')
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
    <script>
        $(document).on('keyup', '.number', function () {
            let earn = $(this).val();
            $(this).val(formatNumber(earn));
        })

        $(document).on('click', '#add_new_status', function () {
            $.ajax({
                url: '{{route('tips.store')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })

        $(document).on('click', '.save-status', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
                price: $(this).closest('tr').find('#price').val(),
                location_id: $(this).closest('tr').find('.location_id').val(),
            }
            $.ajax({
                url: 'tips/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
    </script>
@endsection
