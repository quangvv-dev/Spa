<div class="card-header isShowView" style="display:none;">
    <div class="col-md-2 col-xs-12">
        <select name="source" class="form-control source select2">
            <option value="">Nguồn</option>
            @foreach($source as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="group_product" class="form-control group-product select2">
            <option value="">MKT phụ trách</option>
            @foreach($marketingUsers as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select hidden name="gender" class="form-control gender">
            <option value="">Giới tính</option>
            <option value="0">Nữ</option>
            <option value="1">Nam</option>
        </select>
        <select name="last_time" class="form-control last_time select2">
            <option value="">Tương tác</option>
            @foreach(\App\Models\Customer::last_time_label as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        {!! Form::select('location_id',$location, null, array('class' => 'form-control location','placeholder'=>'Cụm khu vực')) !!}
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="carepage_id" class="form-control carepage select2">
            <option value="">Người tạo</option>
            @foreach($carePageUsers as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="cskh_id" class="form-control cskh select2">
            <option value="">CSKH</option>
            @foreach($cskh as $k=> $item)
                <option value="{{$item->id}}">{{ $item->full_name}}</option>
            @endforeach
        </select>
    </div>
</div>
