<div id="registration-form" class="table-responsive tableFixHead table-bordered table-hover"
     style="width: 100%; overflow: auto;">
    <table class="table table-custom">
        <thead>
        <tr>
            <th class="text-center" style="width: 30px;">#</th>
            <th class="text-center">Marketing</th>
            <th class="text-center">Tên nguồn kết nối</th>
            <th class="text-center">Nhóm dịch vụ</th>
            <th class="text-center nowrap">Ưu tiên sale</th>
            <th class="text-center nowrap">Url kết nối v1</th>
            <th class="text-center nowrap">Duyệt</th>
            <th class="text-center required" style="width: 10%;">Chi nhánh</th>
            <th class="text-center" style="width: 105px"><a class="text-white add_new"><i class="fa fa-plus"></i>
                    Thêm</a></th>
        </tr>
        </thead>
        <tbody>
        @if(count($sources))
            @foreach($sources as $key=>$item)
                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td class="text-center">{{@$item->user->full_name}}</td>
                    <td class="text-center">{{$item->name}}</td>
                    <td class="text-center">{{$item->category_text}}</td>
                    <td class="text-center">{{$item->sale_text}}</td>
                    <td class="text-center">
                        <a href="#" class="settingSource" data-url="{{$item->form_html}}"><i class="fa fa-edit"></i>
                            Kết nối</a>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="onAccept"
                               data-id="{{$item->id}}" {{$item->accept ? 'checked' : ''}}></td>
                    <td class="text-center">{{@$item->branch->name}}</td>
                    <td class="text-center">
                        <a class="action-control edit mr-1" data-id="{{$item->id}}" data-item="{{$item}}"
                           href="javascript:void(0)" title="Lưu">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="action-control delete" data-url="/marketing/source-fb/{{$item->id}}"
                           href="javascript:void(0)" title="Xoá">
                            <i class="fa fa-trash"></i>
                        </a>
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
        @if(count($sources))
            {{$sources->links()}}
        @endif
    </div>
</div>
