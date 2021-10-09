<div id="registration-form">
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap table-primary">
            <thead class="bg-primary text-white">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Kho</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">SL kho</th>
                {{--<th class="text-center">SL chờ xuất</th>--}}
                <th class="text-center">Cập nhật</th>
                <th class="text-center">
                    <a id="add_new"><i class="fa fa-plus"></i> Thêm mới</a></th>
            </tr>
            </thead>
            <tbody>
            @if(count($docs))
                @foreach($docs as $k => $item)
                    <tr>
                        <td class="text-center">{{$k+1}}</td>
                        <td class="text-center">{{@$item->branch->name}}
                        </td>
                        <td class="text-center">{{@$item->product->name}}<br>
                            {{--<span class="text-info">({{@$item->product->trademark->name}})</span>--}}
                        </td>
                        <td class="text-center">{{@number_format($item->quantity)}}</td>
                        {{--<td class="text-center">{{@number_format($item->quantity_pending)}}</td>--}}
                        <td class="text-center">{{$item->updated_at}}</td>
                        <td class="text-center">
                            <a class="btn delete" href="javascript:void(0)"
                               data-url="{{ 'product/'.$item->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="7">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
        <div class="pull-left">
            <div class="page-info">
                {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
            </div>
        </div>
        <div class="pull-right">
            {{ $docs->appends(['name' => @$input['name'],'type_category' => @$input['type_category'] ])->links() }}
        </div>
    </div>
</div>
