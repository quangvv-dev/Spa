<div class="modal fade" id="roleTypeModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 60%">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 text-center">
                        <a href="{{ route('orders.create', $customer->id) }}?type=services" class="btn btn-success">Đơn dịch vụ</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ route('orders.create', $customer->id) }}?type=products" class="btn btn-danger">Đơn sản phẩm</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
