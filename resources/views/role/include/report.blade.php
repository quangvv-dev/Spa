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
