<div class="row isShowView" style="display:none; padding-top: 0.5rem">
    <div class="col-md-2 col-xs-12">
        <select name="source" class="form-control select2">
            <option value="">Nguồn khách hàng</option>
            @foreach($source as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        {!! Form::select('locale_id',$locales, null, array('class' => 'form-control select2','placeholder'=>'Tỉnh thành')) !!}
    </div>
</div>
