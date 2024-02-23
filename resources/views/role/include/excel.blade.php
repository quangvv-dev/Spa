<table id="list-user" class="table table-bordered table-hover">
    <thead class="bg-info text-white">
    <tr>
        <th>Quyền thao tác excel</th>
        <th>Tải xuống (Download)</th>
        <th>Đẩy lên (Upload)</th>
        <th>Tất cả</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Dữ liệu thu chi</td>
        <td>
            <input type="checkbox" id="input301" name="permissions[]"
                   value="thu-chi.export" {{@$doc && $doc->hasAccess('thu-chi.export') ? 'checked' : ''}}>
        </td>
        <td></td>
        <td>
            <input type="checkbox" id="group30"
                   onclick="checkAll('group30', 'input30')">
        </td>
    </tr>
{{--    <tr>--}}
{{--        <td>Dữ liệu khách hàng</td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="input311" name="permissions[]"--}}
{{--                   value="customer.export" {{@$doc && $doc->hasAccess('customer.export') ? 'checked' : ''}}>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="input312" name="permissions[]"--}}
{{--                   value="customer.import" {{@$doc && $doc->hasAccess('customer.import') ? 'checked' : ''}}>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="group31"--}}
{{--                   onclick="checkAll('group31', 'input31')">--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td>Dữ liệu đơn hàng</td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="input321" name="permissions[]"--}}
{{--                   value="orders.export" {{@$doc && $doc->hasAccess('orders.export') ? 'checked' : ''}}>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="input322" name="permissions[]"--}}
{{--                   value="orders.import" {{@$doc && $doc->hasAccess('orders.import') ? 'checked' : ''}}>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="group32"--}}
{{--                   onclick="checkAll('group32', 'input32')">--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td>Dữ liệu đã thu trong kỳ</td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="input331" name="permissions[]"--}}
{{--                   value="export.paymentHistory" {{@$doc && $doc->hasAccess('export.paymentHistory') ? 'checked' : ''}}>--}}
{{--        </td>--}}
{{--        <td></td>--}}
{{--        <td>--}}
{{--            <input type="checkbox" id="group33"--}}
{{--                   onclick="checkAll('group33', 'input33')">--}}
{{--        </td>--}}
{{--    </tr>--}}
    </tbody>
</table>
