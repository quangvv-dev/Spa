<div class="modal fade" id="myModalExport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4><i>Export Data khách hàng</i></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customer.export'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <i style="color: red">Chọn trạng thái KH</i><br>
                        {!! Form::select('status',$status, null, array('class' => 'form-control select2','data-placeholder'=>'Tất cả')) !!}
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <i style="color: red">Nhóm khách hàng</i><br>
                        <select name="group" class="form-control group select2">
                            <option value="">Nhóm dịch vụ</option>
                            @foreach($categories as $item)
                                <option value="{{$item->id}}">{{ $item->name}}({{ $item->customers->count() }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Tải xuống</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
