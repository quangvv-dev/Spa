<div class="modal fade modal-custom" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Upload Data khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('customer-import'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <i style="color: red">Vui lòng tải file excel (*xlsx)</i><br><br>
{{--                        {!! Form::file('file', null, array('class' => 'form-control','required'=>true)) !!}--}}
                        <label class="btn btn-info">
                            Browse… <input required name="file" type="file" style="display: none" >
                        </label>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
                        <a href="{{asset('default/data.xlsx')}}" style="color: #ffffff" class="btn btn-warning">Mẫu
                            upload</a>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

