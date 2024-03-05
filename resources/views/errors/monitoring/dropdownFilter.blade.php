<div class="card-header col isShowView" style="display:none;padding: 0">
    <div class="col-xs-12 col-md-3">
        {!! Form::select('user_id',$users, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Tất cả nhân viên vi phạm--')) !!}
    </div>
    <div class="col-xs-12 col-md-2">
        {!! Form::select('classify_id',$classify, null, array('class' => 'form-control select2 header-search','placeholder'=>'--Chọn quy trình--')) !!}
    </div>
    <div class="col-xs-12 col-md-2">
        <select id="active" name="status" class="form-control select2">
            <option value="">Tất cả trạng thái</option>
            <option value="0">Chờ duyệt</option>
            <option value="1">Duyệt</option>
            <option value="2">Không duyệt</option>
        </select>
    </div>
</div>
