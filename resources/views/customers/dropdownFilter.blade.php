<div class="card-header isShowView" style="display:none;">
    <div class="card-header fix-header bottom-card">
        <div class="row">
            <select name="source" class="form-control source">
                <option value="">Nguồn</option>
                @foreach($source as $k=> $item)
                    <option value="{{$k}}">{{ $item}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
