@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <div id="registration-form">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-white">STT</th>
                            <th class="text-white text-center">Tên</th>
                            <th class="text-white text-center" style="width: 20%;">T/g báo đỏ</th>
                            <th class="text-white text-center" style="width: 20%;">T/g chuyển cskh</th>
                            <th class="text-white text-center">Trạng thái chuyển tiếp theo</th>
                            <th class="text-center nowrap">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($time_status as $key => $item)
                            <tr>
                                <th class="text-center">{{$key+1}}</th>
                                <td class="text-center">{{@$item->status->name}}</td>
                                <td class="text-center">
                                    {{--{{$item->expired_time}}--}}
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control txt-dotted height-30 expired_time"
                                                   value="{{$item->expired_time}}">
                                        </div>
                                        <div class="col-6">
                                            <select name="" id="" class="form-control type_expired_time">
                                                <option value="1"  {{$item->type_expired_time==1 ? 'selected':''}}>Ngày</option>
                                                <option value="2"  {{$item->type_expired_time==2 ? 'selected':''}}>Giờ</option>
                                                <option value="3"  {{$item->type_expired_time==3 ? 'selected':''}}>Phút</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{--{{$item->time_move_cskh}}--}}
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control txt-dotted height-30 time_move_cskh"
                                                   value="{{$item->time_move_cskh}}">
                                        </div>
                                        <div class="col-6">
                                            <select name="" id="" class="form-control type_move_cskh">
                                                <option value="1" {{$item->type_move_cskh==1 ? 'selected':''}}>Ngày</option>
                                                <option value="2" {{$item->type_move_cskh==2 ? 'selected':''}}>Giờ</option>
                                                <option value="3" {{$item->type_move_cskh==3 ? 'selected':''}}>Phút</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form>
                                        <select name="" id="" class="select2 form-control status_next">
                                            @forelse($status as $item1)
                                                <option {{$item->status_id_next == $item1->id ? 'selected' : ''}} value="{{$item1->id}}">{{$item1->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </form>
                                    {{--{{@$item->statusNext->name}}--}}
                                </td>
                                </td>
                                <td class="text-center">
                                    <a class="btn save" data-id="{{$item->id}}"><i class="fas fa-save"></i></a>
                                    <a class="btn delete" href="javascript:void(0)"
                                       data-url="{{ url('settings/time-status/' . $item->id) }}"><i class="fas fa-trash-alt"></i></a>
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
        // edit
        $(document).on('click', '.save', function () {

            let id = $(this).data('id');

            let expired_time = $(this).closest('tr').find('.expired_time').val();
            let type_expired_time = $(this).closest('tr').find('.type_expired_time').val();

            let time_move_cskh = $(this).closest('tr').find('.time_move_cskh').val();
            let type_move_cskh = $(this).closest('tr').find('.type_move_cskh').val();

            let status_id_next = $(this).closest('tr').find('.status_next').val();

            $.ajax({
                url:`/settings/time-status/${id}`,
                method:'put',
                data:{
                    expired_time:expired_time,
                    type_expired_time:type_expired_time,
                    time_move_cskh:time_move_cskh,
                    type_move_cskh:type_move_cskh,
                    status_id_next:status_id_next
                },
                success:function (data) {
                    if(data && data == 1){
                        swal({
                            title: 'Cập nhật thành công !',
                            type: "success",
                            confirmButtonClass: 'btn-success waves-effect waves-light',
                        })
                    } else {
                        swal({
                            title: 'Đã có lỗi xảy ra !',
                            type: "error",
                            confirmButtonClass: 'btn-danger waves-effect waves-light',
                        })
                    }

                }
            })

        });

    </script>
@endsection
