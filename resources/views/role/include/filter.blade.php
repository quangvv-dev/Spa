<table id="list-user" class="table table-bordered table-hover">
    <thead class="bg-info text-white">
    <tr>
        <th>Option tìm kiếm</th>
        <th>Bật/Tắt</th>
    </tr>
    </thead>
    <tbody>

    @foreach($filter as $key => $value)
        <tr>
            <td>{{__('permissions.'.$value) }}</td>

            <td>
                <input type="checkbox" id="input4{{$key}}" name="permissions[]"
                       value="{{$value}}" {{@$doc && $doc->hasAccess($value) ? 'checked' : ''}}>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
