<div class="cont">
    @forelse($customer->historyStatus as $item)
        <div class="container-arrow {{$item->status_id == $customer->status_id?'selected':''}}">
        <div class="arrow-before"></div>
            <div class="text-arrow">
                <span class="status">{{@$item->status->name}}</span>
                <span
                    class="time">{{!empty($item->updated_at)?diffTimeTwo($item->created_at,$item->updated_at):diffTimeTwo($item->created_at,now())}}</span>
            </div>
            <div class="arrow-after"></div>
        </div>
    @empty
    @endforelse
{{--    <div class="container-arrow selected">--}}
{{--        <div class="arrow-before"></div>--}}
{{--        <div class="text-arrow">--}}
{{--            <span class="status">Mới</span>--}}
{{--            <span class="time">2 phút</span>--}}
{{--        </div>--}}
{{--        <div class="arrow-after"></div>--}}
{{--    </div>--}}
</div>
