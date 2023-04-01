<div class="row mt-5">
    <div class="col-4"></div>
    <div class="col-4">
        <div class="row">
            <div class="col-8 col-6-custom text-left">
                @forelse($key as $item)
                    <p>{{$item}}</p>
                @empty
                    <span>Không có dữ liệu</span>
                @endforelse
            </div>

            <div class="col-4 col-6-custom text-right">
                @forelse($value as $item)
                    <p>{{is_integer($item) ? number_format($item): $item }}</p>
                @empty
                @endforelse
            </div>
        </div>
        <div class="row">
            {{--<p></p>--}}
            @if($docs && $docs->all_total)
                <div class="col-12 text-right">
                     <p>Đã chuyển khoản: {{number_format($docs->all_total)}} (VND)</p>
                </div>
            @endif
        </div>
    </div>
    <div class="col-4"></div>
</div>