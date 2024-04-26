<div class="cont">
    @forelse($customer->historyStatus as $k => $item)
        <div class="container-arrow {{$k == count($customer->historyStatus) - 1?'selected':''}}">
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
</div>
