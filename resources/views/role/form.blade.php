<div class="col-xs-12 col-lg-6">
    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
        {!! Form::label('name', 'Tên', array('class' => ' required')) !!}
        {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>
<div class="col-xs-12 col-lg-6">
    <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
        {!! Form::label('description', 'Mô tả') !!}
        {!! Form::text('description', null, array('class' => 'form-control')) !!}
        <span class="help-block">{{ $errors->first('description', ':message') }}</span>
    </div>
</div>
<div class="col-xs-12 col-lg-6">
    <div class="form-group required {{ $errors->has('department_id') ? 'has-error' : '' }}">
        {!! Form::label('department_id', 'Phòng ban', array('class' => ' required')) !!}
        {!! Form::select('department_id',$department, null, array('class' => 'form-control header-search','placeholder'=>'--Chọn phòng ban--', 'required' => true)) !!}
        <span class="help-block">{{ $errors->first('department_id', ':message') }}</span>
    </div>
</div>

<div class="table-responsive col-md-12">
    @include('role.include.module')
    @include('role.include.report')
    @include('role.include.others')
    @include('role.include.filter')
    @include('role.include.excel')
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-outline-primary mr-1">
        <i class="ft-check"></i> Lưu Lại
    </button>

    <button type="button" class="btn btn-outline-warning" onclick="location.href='{{route('roles.index')}}';">
        <i class="ft-x"></i> Trở lại
    </button>

</div>
