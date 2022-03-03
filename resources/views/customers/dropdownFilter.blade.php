<div class="card-header isShowView" style="display:none;">
    <div class="fix-header bottom-card">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <select name="source" class="form-control source">
                    <option value="">Nguồn</option>
                    @foreach($source as $k=> $item)
                        <option value="{{$k}}">{{ $item}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-xs-12">
                <select name="gender" class="form-control gender">
                    <option value="">Giới tính</option>
                    <option value="0">Nữ</option>
                    <option value="1">Nam</option>
                </select>
            </div>
        </div>
    </div>
</div>
