<div class="isShowView row" style="display:none;margin-top: 5px">
    <div class="col-md-2 col-xs-12">
        <select name="mkt_id" class="form-control">
            <option value="">MKT phụ trách</option>
            @foreach($marketingUsers as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        {!! Form::select('is_upsale', [0 =>'Khách hàng mới',1 =>'Khách hàng cũ'], null, array('class' => 'form-control', 'placeholder'=>'Loại khách hàng')) !!}
    </div>
</div>