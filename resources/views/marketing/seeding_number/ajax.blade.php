<div class="table-responsive tableFixHead table-bordered table-hover"
     style="width: 100%; overflow-x: auto;">
    <table class="table table-custom">
        <thead>
        <tr>
            <th class="text-center" style="width: 30px;"><input type="checkbox"
                                                                id="checkAll"></th>
            <th class="text-center" style="width: 30px;">#</th>
            <th class="text-center">Số seeding</th>
            <th class="text-center">Người tạo</th>
            <th class="text-center">Cập nhật</th>
            <th class="text-center" style="width: 90px">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if(count($data))
            @foreach($data as $key=>$item)
                <tr>
                    <td class="text-center"><input type="checkbox" getData value="{{$item->id}}">
                    </td>
                    <td class="text-center">{{$key+1}}</td>
                    <td class="text-center">{{$item->seeding_number}}</td>
                    <td class="text-center">
                        {{$item->user->name}} <br>
                        <span class="small-tip">{{$item->created_at}}</span>
                    </td>
                    <td class="text-center">
                        {{$item->user->name}} <br>
                        <span class="small-tip">{{$item->updated_at}}</span>
                    </td>
                    <td class="text-center">
                        <a class="action-control delete" data-id="{{$item->id}}" href="javascript:void(0)">
                            <i class="fa fa-trash fa-2x"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">
                    Không có bản ghi nào.
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="mt-2">
        {{--{{$data->links()}}--}}
    </div>
</div>
