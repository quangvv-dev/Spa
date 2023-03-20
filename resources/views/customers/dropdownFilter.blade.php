<div class="card-header isShowView" style="display:none;">
    <div class="col-md-2 col-xs-12">
        <select name="source" class="form-control source">
            <option value="">Nguồn</option>
            @foreach($source as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="marketing" class="form-control group-product" id="marketing">
            <option value="">MKT phụ trách</option>
            @foreach($marketingUsers as $k=> $item)
                <option value="{{$k}}">{{ $item}}</option>
            @endforeach
        </select>
    </div>
    {{--<div class="col-md-2 col-xs-12">--}}
        {{--<select name="gender" class="form-control gender">--}}
            {{--<option value="">Giới tính</option>--}}
            {{--<option value="0">Nữ</option>--}}
            {{--<option value="1">Nam</option>--}}
        {{--</select>--}}
    {{--</div>--}}
    <div class="col-md-2 col-xs-12">
        <select name="age_from" class="form-control">
            <option value="">Chọn độ tuổi</option>
            @foreach($age_from as $k=> $item)
                <option value="{{$k}}">{{$item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-12">
        <select name="customer_job" class="form-control">
            <option value="">Chọn nghề nghiệp</option>
            @foreach($customer_job as $k=> $item)
                <option value="{{$k}}">{{$item}}</option>
            @endforeach
        </select>
    </div>

    {{--<div class="col-md-2">--}}
        {{--{!! Form::select('location_id',$location, null, array('class' => 'form-control location','placeholder'=>'Cụm khu vực')) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-2 col-xs-12">--}}
        {{--<select name="carepage_id" class="form-control carepage">--}}
            {{--<option value="">Người tạo</option>--}}
            {{--@foreach($carePageUsers as $k=> $item)--}}
                {{--<option value="{{$k}}">{{ $item}}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
    {{--</div>--}}
    <div class="col-md-2 col-xs-12">
        <select name="type_search_date" class="form-control gender">
            <option value="">Ngày data về hệ thống</option>
            <option value="0">Ngày data tác nghiệp</option>
            <option value="1">Ngày có lịch hẹn</option>
        </select>
    </div>
</div>
