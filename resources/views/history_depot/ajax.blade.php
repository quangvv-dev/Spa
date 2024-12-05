<div id="registration-form">
    <div class="table-responsive tableFixHead table-bordered table-hover">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Kho</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Nghiêp vụ</th>
                <th class="text-center">Số lượng nhập/xuất</th>
                {{--<th class="text-center">Số lượng chờ xuất</th>--}}
                {{--<th class="text-center">Mã đơn</th>--}}
                <th class="text-center">Ghi chú</th>
                <th class="text-center">Cập nhật</th>
                <th class="text-center">
                    <a data-toggle="modal" data-target="#add_new"><i class="fa fa-plus"></i> Tạo mới</a>
                </th>
            </tr>
            </thead>
            <tbody>
            @if(count($docs))
                @foreach($docs as $key => $item)
                    <tr>
                        <td class="text-center">{{@$key+1}}</td>
                        <td class="text-center">{{@$item->branch->name}}</td>
                        <td class="text-center">{{@$item->product->name}} </td>
                        <td class="text-center">{{@$status[$item->status]}}</td>
                        <td class="text-center">{{@number_format($item->quantity)}}</td>
                        {{--<td class="text-center">{{@number_format($item->quantity_pending)}}</td>--}}
                        {{--<td class="text-center">{{@$item->code_order}}</td>--}}
                        <td class="text-center">{{@$item->note}}</td>
                        <td class="text-center">{{$item->created_at}}</td>
                        <td class="text-center">
                            @if($item->status == \App\Constants\OrderConstant::NHAP_KHO||$item->status == \App\Constants\OrderConstant::TANG_KHACH)
                                <a class="btn delete" href="javascript:void(0)" data-url="{{url('/depots/history/'.$item->id)}}"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="10">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
        <div class="float-right">
            {{$docs->links()}}
        </div>
    </div>
</div>

