<div class="isShowView row" style="display:none;margin-top: 5px">
    <div class="col-md-2 col-xs-12">
        <select name="mkt_id" class="form-control select2">
            <option value="">MKT phụ trách</option>
            @foreach($marketingUsers as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="carepage_id" class="form-control select2">
            <option value="">Carepage phụ trách</option>
            @foreach($carepages as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        {!! Form::select('is_upsale', [0 =>'Đơn mới',1 =>'Đơn upsale'], null, array('class' => 'form-control select2', 'placeholder'=>'Loại đơn')) !!}
    </div>
    @if(auth()->user()->permission('export.paymentHistory'))
        <a title="Tải Excel" class="btn download" href="javascript:void(0)">
            <i class="fas fa-download"></i>
        </a>
    @endif
</div>
