<div class="modal fade modal-custom" id="myModalImport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Upload Data Sản phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('product.import'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <i style="color: red">Vui lòng tải file excel (*xlsx)</i><br><br>
{{--                        {!! Form::file('file', null, array('class' => 'form-control','required'=>true)) !!}--}}
                        <label class="btn btn-primary">
                            Browse… <input required name="file" type="file" style="display: none" >
                        </label>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

