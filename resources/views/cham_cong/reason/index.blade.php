@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3></br>
            </div>
            <div id="registration-form">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-primary">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-white">STT</th>
                            <th class="text-white text-center">Lý do</th>
                            <th class="text-white text-center">Số lần / tháng</th>
                            <th class="text-white text-center">Type</th>
                            <th class="text-center nowrap">
                                <a id="add_new_reason" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reasons as $key => $item)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td class="text-center"><input type="text" class="form-control name" value="{{$item->name}}"></td>
                                <td class="text-center"><input type="text" class="form-control count" value="{{$item->count}}"></td>
                                <td>
                                    <select name="" id="" class="form-control type">
                                        <option value="0">Đơn Nghỉ</option>
                                        <option value="1">Đơn Checkin/Checkout</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <a class="btn save save-reason" data-id="{{$item->id}}"><i class="fas fa-save"></i></a>
                                    <a class="btn delete" href="javascript:void(0)"
                                       data-url="{{ url('approval/reason/' . $item->id) }}"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
                            </tr>
                        @endforelse
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('_script')
    <script>
        $(document).on('click', '#add_new_reason', function () {
            $.ajax({
                url: '{{route('approval.reason.store')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                    console.log(data);
                }
            })
        })

        $(document).on('click', '.save-reason', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
                count: $(this).closest('tr').find('.count').val(),
            }
            $.ajax({
                url: `/approval/reason/${id}`,
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
