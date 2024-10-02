<div class="modal fade modal-custom" id="uploadModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Cập nhật hồ sơ khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('personal.import'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <i style="color: red">Vui lòng tải file excel (*xlsx)</i><br><br>
                        <input type="file" name="file" id="file" class="inputfile"/>
                        <label for="file" class="tooltip-nav">
                            <span class="btn btn-info">Browse…</span>
                        </label>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{asset('default/import_profile_employee.xlsx')}}" style="color: #ffffff" class="btn btn-warning">Mẫu
                            upload</a>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

