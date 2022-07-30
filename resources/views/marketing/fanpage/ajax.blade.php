<div id="registration-form" class="table-responsive tableFixHead table-bordered table-hover">
    <form action="">
        <table class="table table-custom">
            <thead>
            <tr>
                <th class="text-center" style="width: 5%;"></th>
                <th class="text-center" style="width: 20%;">Fanpage</th>
                <th class="text-center" style="width: 15%;">Trạng thái quyền hạn</th>
                <th class="text-center required nowrap" style="width: 5%;">Sử dụng</th>
                <th class="text-center required" style="width: 15%;">Source</th>
                <th class="text-center" style="width: 10%;">Thông tin cập nhật cuối</th>
                {{--<th class="text-center" style="width: 5%;">Đồng bộ</th>--}}
                <th class="text-center" style="width: 10%">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fanpages as $item)
                <tr>
                    <td class="text-center"><img src="{{@$item->avatar}}" alt=""></td>
                    <td class="text-center">
                        <a href="https://facebook.com/{{$item->page_id}}">{{$item->name}}<br>
                            <span>{{$item->page_id}}</span>
                        </a>
                    </td>
                    <td class="text-center">{{$item->role_text}}</td>
                    <td class="text-center">
                        <input type="checkbox" {{$item->used?'checked':''}} class="used">
                    </td>
                    <td class="text-center">
                        {!! Form::select('source', $source, @$item->source_id, array('class' => 'form-control select2 square source','placeholder'=>'--Source--')) !!}
                        <p class="small-tip">Source đã cấu hình bởi: {{@$item->user->name}}</p>
                    </td>
                    <td class="text-center">
                        <p>{{$item->updated_at}}</p>
                    </td>
                    <td class="text-center">
                        <a class="action-control mr-1 save" href="javascript:void(0)"
                           data-id="{{$item->id}}"
                           data-token="{{$item->access_token}}"
                           data-fanpageId="{{$item->page_id}}"
                           title="Lưu"><i class="fa fa-save"></i></a>
                        <a class="action-control mr-1"
                           href="{{route('marketing.fanpage-post.index')}}"
                           data-id="1" title="Danh sách bài post"><i
                                    class="fa fa-list"></i></a>
                        <a class="action-control retweet"
                           data-show="{{$item->used?'true':'false'}}"
                           data-fanpageId="{{$item->page_id}}"
                           data-token="{{$item->access_token}}"
                           href="javascript:void(0)"
                           title="Đồng bộ bài post theo cấu hình">
                            <i class="fa fa-retweet" aria-hidden="true"></i>
                        </a>
                        <a href="/marketing/chat-messages/{{$item->page_id}}" class="tooltip-nav">
                            <i class="mdi mdi-facebook-box" aria-hidden="true"></i>
                            <span class="tooltiptext">Nhập khách hàng (excel)</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
    <div class="float-right">
        {{$fanpages->links()}}
    </div>
</div>
