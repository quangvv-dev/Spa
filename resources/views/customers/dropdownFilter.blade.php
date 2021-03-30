<div class="card-header isShowView" style="display:none;">
    <div class="card-header fix-header bottom-card">
        <div class="row">
            <select name="branch_id" class="form-control branch_id">
                <option value="">Tất cả chi nhánh</option>
                @foreach($branchs as $k=> $item)
                    <option value="{{$k}}">{{ $item}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
