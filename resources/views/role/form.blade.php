{{--<div class="tab-pane">--}}
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
    <table id="list-user" class="table table-bordered table-hover">
        <thead class="bg-info text-white">
        <tr>
            <th>Quyền quản trị hệ thống</th>
            <th>Xem danh sách</th>
            <th>Sửa</th>
            <th>Thêm</th>
            <th>Xóa</th>
            <th>Tất cả</th>
        </tr>
        </thead>
        <tbody>
        @foreach($module as $key => $value)
            <tr>
                <td>{{__('permissions.'.$value) }}</td>
                @foreach($permissions as $k => $v)
                    @php
                        $k++;
                    @endphp
                    <td>
                        {{--                                @if(isset($doc) && $doc->id == \App\Constants\StatusCode::ADMIN && in_array($value.'.'.$v,$none_admin))--}}
                        {{--                                @else--}}
                        <input type="checkbox" id="input{{$key}}{{$k}}" name="permissions[]"
                               value="{{$value}}.{{$v}}" {{@$doc && $doc->hasAccess($value.'.'.$v) ? 'checked' : ''}}>
                        {{--                                @endif--}}
                    </td>
                @endforeach
                <td>
                    <input type="checkbox" id="group{{$key}}"
                           onclick="checkAll('group{{$key}}', 'input{{$key}}')">
                </td>
            </tr>

        @endforeach
        <tr>
            <td>QL đơn hàng</td>
            <td>
                <input type="checkbox" id="input171" name="permissions[]"
                       value="order.list" {{@$doc && $doc->hasAccess('order.list') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input173" name="permissions[]"
                       value="order.edit" {{@$doc && $doc->hasAccess('order.edit') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input172" name="permissions[]"
                       value="order.add" {{@$doc && $doc->hasAccess('order.add') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input174" name="permissions[]"
                       value="order.delete" {{@$doc && $doc->hasAccess('order.delete') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="group17"
                       onclick="checkAll('group17', 'input17')">
            </td>
        </tr>
        <tr>
            <td>QL thu chi</td>
            <td>
                <input type="checkbox" id="input181" name="permissions[]"
                       value="thu-chi.list" {{@$doc && $doc->hasAccess('thu-chi.list') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input183" name="permissions[]"
                       value="thu-chi.edit" {{@$doc && $doc->hasAccess('thu-chi.edit') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input182" name="permissions[]"
                       value="thu-chi.add" {{@$doc && $doc->hasAccess('thu-chi.add') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="input184" name="permissions[]"
                       value="thu-chi.delete" {{@$doc && $doc->hasAccess('thu-chi.delete') ? 'checked' : ''}}>
            </td>
            <td>
                <input type="checkbox" id="group18"
                       onclick="checkAll('group18', 'input18')">
            </td>
        </tr>
        </tbody>
    </table>

    <table id="list-user" class="table table-bordered table-hover">
        <thead class="bg-info text-white">
        <tr>
            <th>Thống kê</th>
            <th>Xem và tìm kiếm</th>
        </tr>
        </thead>
        <tbody>
        @foreach($report as $key => $value)
            <tr>
                <td>{{__('permissions.'.$value) }}</td>

                <td>
                    <input type="checkbox" id="input{{$key}}" name="permissions[]"
                           value="{{$value}}" {{@$doc && $doc->hasAccess($value) ? 'checked' : ''}}>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table id="list-user" class="table table-bordered table-hover">
        <thead class="bg-info text-white">
        <tr>
            <th>Quyền khác & nâng cao</th>
            <th>Xem và thao tác</th>
        </tr>
        </thead>
        <tbody>
        @foreach($other as $key => $value)
            <tr>
                <td>{{__('permissions.'.$value) }}</td>

                <td>
                    <input type="checkbox" id="input{{$key}}" name="permissions[]"
                           value="{{$value}}" {{@$doc && $doc->hasAccess($value) ? 'checked' : ''}}>
                </td>
            </tr>
        @endforeach
        <tr>
            <td>QL danh mục thu chi</td>
            <td>
                <input type="checkbox" id="input9" name="permissions[]"
                       value="danh-muc-thu-chi.index" {{@$doc && $doc->hasAccess('danh-muc-thu-chi.index') ? 'checked' : ''}}>
            </td>
        </tr>
        </tbody>
    </table>

</div>


{{--</div>--}}
<div class="form-actions">
    <button type="submit" class="btn btn-outline-primary mr-1">
        <i class="ft-check"></i> Lưu Lại
    </button>

    <button type="button" class="btn btn-outline-warning" onclick="location.href='{{route('roles.index')}}';">
        <i class="ft-x"></i> Trở lại
    </button>

</div>
