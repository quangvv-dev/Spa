<div class="modal fade" id="myModalExport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Export Data khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customer.export'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <i style="color: red">Chọn trạng thái KH</i><br><br>
                        {!! Form::select('status',$status, null, array('class' => 'form-control select2','data-placeholder'=>'Tất cả')) !!}
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
