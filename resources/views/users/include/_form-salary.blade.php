<div class="row mt-5">
    <div class="col-4"></div>
    <div class="col-4">
        <div class="row">
            @if($docs && $docs->all_total)
                <div class="col-12 text-right">
                    <p>Đã chuyển khoản: {{number_format($docs->all_total)}} (VND)</p>
                </div>
            @endif
        </div>
            <div class="divider row">
                @forelse($key as $key => $item)
                    @if(!empty($item))
                        <div class="col-8 col-6-custom text-left">
                            <p>{{$item}}</p>
                        </div>
                        <div class="col-4 col-6-custom text-right">
                            <p>{{is_numeric(@$value[$key]) && strlen((int)$value[$key]) < 9 ?number_format($value[$key]):$value[$key]}}</p>
                        </div>
                    @endif
                @empty
                    <span>Không có dữ liệu</span>
                @endforelse
            </div>
    </div>
    <div class="col-4"></div>
</div>
