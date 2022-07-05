<div id="registration-form">
    <div class="table card-table table-vcenter text-nowrap table-primary"
         style="width: 100%; overflow-x: auto;">
        <table class="table-sortable1 table table-custom">
            <thead>
            <tr>
                <th class="text-center" style="width: 30px;">STT</th>
                <th class="text-center nowrap">Thủ thuật</th>
                <th class="text-center">Giá công</th>
                <th class="text-center">
                    <a id="add_new_status" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                </th>
            </tr>
            </thead>
            <tbody id="sortable1">
            @if(count($tips))
                @foreach($tips as $k =>$item)
                    <tr data-id="{{$item->id}}">

                        <td class="text-center">
                            {{$k+1}}
                        </td>
                        <td class="text-center">
                            <input type="text" class="name txt-dotted form-control" value="{{$item->name}}">
                        </td>
                        <td class="text-center">
                            <input type="text" id="price" class="txt-dotted form-control number" value="{{number_format($item->price)}}">
                        </td>
                        <td class="text-center">
                            <a class="btn save-status" href="javascript:void(0)" data-id="{{$item->id}}"><i class="fa fa-save"></i>
                            </a>
                            <a class="btn delete" href="javascript:void(0)" data-url="{{'tips/'.$item->id}}"><i class="fa fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td id="no-data" class="text-center" colspan="5">Không tồn tại dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
        <div class="pull-left">
            <div class="page-info">
                {{ 'Tổng số ' . $tips->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
            </div>
        </div>
        <div class="pull-right">
            {{ $tips->appends([])->links() }}
        </div>
    </div>
</div>

