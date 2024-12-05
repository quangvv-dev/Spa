<div id="registration-form" class="table-responsive tableFixHead table-bordered table-hover"
     style="width: 100%; overflow: auto;">
    <table class="table table-custom">
        <thead>
        <tr>
            <th class="text-center" style="width: 30px;">#</th>
            <th class="text-center">Fanpage</th>
            <th class="text-center">Mã bài viết</th>
            <th class="text-center">Nội dung</th>
            <th class="text-center nowrap">Ngày đăng</th>
            <th class="text-center nowrap">Sử dụng</th>
            <th class="text-center required" style="width: 10%;">Source</th>
            <th class="text-center" style="width: 105px"><a href="" data-toggle="modal" data-target="#modalFanpagePost" class="text-white"><i class="fa fa-plus"></i> Thêm
                    mới</a></th>
        </tr>
        </thead>
        <tbody>
        @if(count($posts))
            @foreach($posts as $key=>$value)
                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td class="text-center">
                        <img src="{{@$value->fanpage->avatar}}"
                             style="border-radius: 50%">
                    </td>
                    <td class="text-center">{{$value->post_id}}</td>
                    <td class="text-center">{{$value->title}}</td>
                    <td class="text-center">{{$value->post_created}}</td>
                    <td class="text-center">
                        <input class="used"
                               type="checkbox" {{$value->used == \App\Constants\FanpageConstant::FANPAGE_POST_USED?'checked':''}}>
                    </td>
                    <td class="text-center">
                        {!! Form::select('source', $source, @$value->source_id, array('class' => 'form-control select2 square source','placeholder'=>'--Source--')) !!}
                    </td>
                    <td class="text-center">
                        <a class="action-control save" data-id="{{$value->id}}"
                           href="javascript:void(0)" title="Lưu">
                            <i class="fa fa-save fa-2x"></i>
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
        @if(count($posts))
            {{$posts->links()}}
        @endif
    </div>
</div>
