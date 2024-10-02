<div class="modal fade modal-custom" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Tạo chức vụ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('position/'.$id), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('name', 'Chức vụ', array('class' => ' required')) !!}
                        {!! Form::text('name', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>

    </div>

</div>

<div class="modal fade modal-custom" id="updateModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Cập nhật chức vụ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('position/'.$id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                <div class="row">
                    {!! Form::hidden('id', null, array('class' => 'form-control','id'=>'update_id')) !!}
                    <div class="col-md-12">
                        {!! Form::label('name', 'Chức vụ', array('class' => ' required')) !!}
                        {!! Form::text('name', null, array('class' => 'form-control','required'=>true,'id'=>'update_name')) !!}
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>

    </div>

</div>
