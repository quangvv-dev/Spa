<div class="card-header isShowView" style="display:none;">
    <div class="col-2 mt-2">
        {!! Form::select('thuc_hien_id', $users, null, array('class' => 'form-control select2','id'=>'branch','placeholder'=>'Chọn người tạo')) !!}
    </div>
    <div class="col-2 mt-2">
        {!! Form::select('duyet_id', $users, null, array('class' => 'form-control select2','id'=>'branch','placeholder'=>'Chọn người duyệt')) !!}
    </div>
</div>
