<div id="registration-form">
    <div class="table-responsive tableFixHead table-bordered table-hover">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Kho</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Tồn</th>
                <th class="text-center">Xuất bán</th>
                <th class="text-center">Tiêu hao/hỏng</th>
                <th class="text-center">Dự kiến bán hết</th>
                <th class="text-center">
                    <a data-toggle="modal" data-target="#add_new"><i class="fa fa-plus"></i> Thêm mới
                    </a>
                </th>
            </tr>
            <tr class="bold">
                <td class="text-center bold" colspan="2">Tổng</td>
                <td class="text-center bold" ></td>
                <td class="text-center bold">{{@number_format($docs->sum('quantity'))}} </td>
                <td class="text-center bold">{{@number_format($docs->sum('xuat_ban'))}}</td>
                <td class="text-center bold">{{@number_format($docs->sum('tieu_hao'))}}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>

            </tr>
            </thead>
            <tbody>
            @if(count($docs))
                @foreach($docs as $key => $item)
                    {{--{{dd($item)}}--}}
                    <tr>
                        <td class="text-center">{{@$key+1}}</td>
                        <td class="text-center">{{@$item->branch->name}}</td>
                        <td class="text-center">{{@$item->product->name}}</td>
                        <td class="text-center">{{@number_format($item->quantity)}} </td>
                        <td class="text-center">{{@number_format($item->xuat_ban)}}</td>
                        <td class="text-center">{{@number_format($item->tieu_hao)}}</td>
                        <td class="text-center">{{$item->created_at}}</td>
                        <td class="text-center">
                            @if($item->status == \App\Constants\OrderConstant::NHAP_KHO)
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
    </div>
</div>

