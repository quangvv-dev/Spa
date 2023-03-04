<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th ><input type="checkbox" id="checkAll"/></th>
            <th class="text-center">Người tạo</th>
            <th class="text-center">Mã NV</th>
            <th class="text-center">Họ và tên</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Loại đơn</th>
            <th class="text-center">Phòng ban</th>
            <th class="text-center">Vị trí</th>
            <th class="text-center">Lý do</th>
            <th class="text-center">Ngày tạo</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="checkbox" getdataitem></td>
            <td class="text-center">
                <a href="https://adamgroup.1office.vn/approval-approval/list?menu=all&amp;v=list&amp;tab=all&amp;created_by_id=269">
                    <div class="users-summary" v="users" n="1">
                        <img class="userlink lazy-photo online" uid="269" src="https://adamgroup.1office.vn/packages/4x/style/images/letters/t.png" title="Online lúc 14:36:11">
                    </div>
                </a>
            </td>
            <td class="text-center">IT-2</td>
            <td class="text-center">Nguyễn Minh Tiến</td>
            <td class="text-center">
                <a href="https://adamgroup.1office.vn/approval-approval/list?menu=all&amp;v=list&amp;tab=all&amp;app_approval_status=APPROVED">
                    <div class="beacon-green" style="opacity:0.8;width:120px">Đã duyệt</div>
                </a>
            </td>
            <td class="text-center">Đơn xin nghỉ</td>
            <td class="text-center">Phòng công nghệ</td>
            <td class="text-center">IT</td>
            <td class="text-center">Nghỉ ốm</td>
            <td class="text-center">15/02/2023</td>
        </tr>
        </tbody>
    </table>
    {{--<div class="pull-left">--}}
    {{--<div class="page-info">--}}
    {{--{{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="pull-right">--}}
    {{--{{ $docs->appends(['search' => request()->search ])->links() }}--}}
    {{--</div>--}}
    <div class="float-right">
        {{$docs->links()}}
    </div>
</div>

