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
        <td>Duyệt nguồn</td>
        <td>
            <input type="checkbox" id="input10" name="permissions[]"
                   value="source.update" {{@$doc && $doc->hasAccess('source.update') ? 'checked' : ''}}>
        </td>
    </tr>
    <tr>
        <td>QL danh mục thu chi</td>
        <td>
            <input type="checkbox" id="input9" name="permissions[]"
                   value="danh-muc-thu-chi.index" {{@$doc && $doc->hasAccess('danh-muc-thu-chi.index') ? 'checked' : ''}}>
        </td>
    </tr>
    <tr>
        <td>QL thời gian quá hạn</td>
        <td>
            <input type="checkbox" id="input11" name="permissions[]"
                   value="time-status.index" {{@$doc && $doc->hasAccess('time-status.index') ? 'checked' : ''}}>
        </td>
    </tr>
    </tbody>
</table>
