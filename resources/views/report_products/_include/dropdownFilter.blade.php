<div class="card-header isShowView" style="display:none;">
    <div class="col-md-2 col-xs-12">
        <select name="source" class="form-control source select2">
            <option value="">Nguồn</option>
            @foreach($source as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        {!! Form::select('location_id',$location, null, array('class' => 'form-control location','placeholder'=>'Cụm khu vực')) !!}
    </div>
</div>
