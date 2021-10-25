<div class="modal fade" id="roleTypeModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4 text-center">
                        <a href="{{ route('ordersService.create', $customer->id) }}?type=services" class="btn btn-success">Dịch vụ</a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="{{ route('orders.create', $customer->id) }}?type=products" class="btn btn-danger">Sản phẩm</a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="{{ route('ordersService.create', $customer->id) }}?type=combos" class="btn btn-info">Sản phẩm & dịch vu</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
