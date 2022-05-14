<div class="table-responsive">
    <div class="row">
        @forelse($fanpages as $item)
            <div class="col-3">
                <div class="card border-info box-shadow-0 bg-transparent">
                    <div class="card-content">
                        <img src="{{$item->avatar?:'/images/avatar.jpg'}}" alt="element 04" width="90"
                             class="float-left img-fluid">
                        <div class="card-body pt-3 f-page">
                            <p class="">{!! @str_limit(strip_tags($item->name),120) !!}
                                {{strlen($item->name) >120 ? '...' : ''}}</p>
                            <p class="small-tip">{{@$item->user->full_name}}</p>
                            {{--<span ></span>--}}
                        </div>
                        <input type="checkbox" class="checkbox" value="{{$item->page_id}}" data-token="{{$item->access_token}}" data-name="{{$item->name}}">
                    </div>
                </div>
            </div>
        @empty
            <p>Không có kết quả nào</p>
        @endforelse
    </div>
    <div class="float-right">

        <select id="customPage" style="height: 33px !important;">
            <option value="20" {{isset($paginate) && $paginate == 20 ? 'selected' : ''}}>20</option>
            <option value="50" {{isset($paginate) && $paginate == 50 ? 'selected' : ''}}>50</option>
            <option value="100" {{isset($paginate) && $paginate == 100 ? 'selected' : ''}}>100</option>
            <option value="200" {{isset($paginate) && $paginate == 200 ? 'selected' : ''}}>200</option>
            <option value="300" {{isset($paginate) && $paginate == 300 ? 'selected' : ''}}>300</option>
            <option value="500" {{isset($paginate) && $paginate == 500 ? 'selected' : ''}}>500</option>
        </select>
        @if($fanpages->currentPage() == $fanpages->lastPage())
            <span>({{$fanpages->total()}}/{{$fanpages->total()}})</span>
        @else
            <span>({{$fanpages->currentPage()*$fanpages->perPage()}}/ {{$fanpages->total()}})</span>
        @endif
        {{$fanpages->links()}}



        {{--@if(count($fanpages))--}}
            {{--{{$fanpages->links()}}--}}
        {{--@endif--}}
    </div>
</div>
