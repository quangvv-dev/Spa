    <table class="table card-table table-vcenter text-nowrap table-bordered table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th><input type="checkbox" id="checkAll"/></th>
            <th class="text-center">Mã NV</th>
            <th class="text-center">Họ và tên</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Loại đơn</th>
            <th class="text-center">Phòng ban</th>
            <th class="text-center">Chức vụ</th>
            <th class="text-center">Lý do</th>
            <th class="text-center">Ngày tạo</th>
        </tr>
        </thead>
        <tbody>
        @forelse($docs as $item)
            <tr>
                <td><input type="checkbox" getdataitem value="{{$item->id}}"></td>
                <td class="text-center"></td>
                <td class="text-center"><a href="/approval/order/show/{{$item->id}}/{{$item->type}}">{{@$item->user->full_name}}</a></td>
                <td class="text-center">
                    <a href="">
                        <div class="{{$item->status==1 ? "beacon-green" : ($item->status==0 ? "beacon-red" : 'beacon-red')}}" style="opacity:0.8;width:120px">
                            {{$item->status==1 ? "Đã duyệt" : ($item->status==0 ? "Chờ duyệt" : 'Không duyệt')}}
                        </div>
                    </a>
                </td>
                <td class="text-center bold">{{$item->type==0 ? "Đơn nghỉ" : 'Đơn check-in/check-out'}}</td>
                <td class="text-center">{{@$item->user->department->name}}</td>
                <td class="text-center">{{@$item->user->roles->name}}</td>
                <td class="text-center">{{@$item->reason->name}}</td>
                <td class="text-center">{{$item->created_at}}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
    {{--<div class="pull-left">--}}
    {{--<div class="page-info">--}}
    {{--{{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="pull-right">--}}
    {{--{{ $docs->appends(['search' => request()->search ])->links() }}--}}
    {{--</div>--}}
    <div class="float-right">
        {{$docs->links()}}
    </div>

