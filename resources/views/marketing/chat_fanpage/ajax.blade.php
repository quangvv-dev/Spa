<div class="table-responsive">
    <div class="row">
        @forelse($fanpages as $item)
            <div class="col-3">
                <div class="card border-info box-shadow-0 bg-transparent">
                    <div class="card-content">
                        <a href="/marketing/chat-messages/{{$item->page_id}}">
                            <img src="{{$item->avatar?:'/images/avatar.jpg'}}" alt="element 04" width="90"
                                 class="float-left img-fluid">
                        </a>
                        <div class="card-body pt-3 f-page">
                            <a href="/marketing/chat-messages/{{$item->page_id}}">
                                <p class="pointer">{!! @str_limit(strip_tags($item->name),120) !!}
                                    {{strlen($item->name) >120 ? '...' : ''}}</p>
                            </a>
                            <p class="small-tip">{{@$item->user->full_name}}</p>
                            {{--<span ></span>--}}
                        </div>
                        {{--<input type="checkbox" class="checkbox {{$item->page_id}}" value="{{$item->page_id}}" data-token="{{$item->access_token}}" data-name="{{$item->name}}">--}}
                    </div>
                </div>
            </div>
        @empty
            <p>Không có kết quả nào</p>
        @endforelse
    </div>
</div>
