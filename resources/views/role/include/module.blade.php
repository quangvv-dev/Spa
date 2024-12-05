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
                    <input type="checkbox" id="input{{$key}}{{$k}}" name="permissions[]"
                           value="{{$value}}.{{$v}}" {{@$doc && $doc->hasAccess($value.'.'.$v) ? 'checked' : ''}}>
                </td>
            @endforeach
            <td>
                <input type="checkbox" id="group{{$key}}"
                       onclick="checkAll('group{{$key}}', 'input{{$key}}')">
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
