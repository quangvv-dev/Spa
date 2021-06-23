<style>
    #orderDetailModal {
        color: black;
    }
</style>
<div class="modal fade" id="orderDetailModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-weight: 900;color: #0fa2e8;">Xem nhanh đơn hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body list-order-detail">
                <div class="customer-info" style="margin-bottom: 10px">

                </div>
                <table class="table card-table table-vcenter table-primary">
                    <thead class="bg-primary text-white">
                    <tr class="bold b-gray">
                        <td class="padding5">Tên sản phẩm</td>
                        <td class="padding5">Số lượng</td>
                        <td class="padding5">Giá trị đơn</td>
                        <td class="padding5">CK (đ)</td>
                        <td class="padding5">Thành tiền</td>
                    </tr>
                    </thead>
                    <tbody class="list1">
                    </tbody>
                </table>
                <div class="btn-group dropup fl task_footer_box" style="margin-top: 15px">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
