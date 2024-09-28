<style>
    .width-180{
        width: 180px;
        margin-bottom: 5px;
    }
</style>
<div class="modal fade modal-custom" id="roleTypeModal" role="dialog">
    <div class="modal-dialog modal-xs">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">

                <div class="row text-center">
                    <div class="col-md-12">
                        <a href="{{ route('ordersService.create', $customer->id) }}?type=services" class="btn btn-success width-180">Dịch vụ</a>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('orders.create', $customer->id) }}?type=products" class="btn btn-danger width-180">Sản phẩm</a>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('ordersService.create', $customer->id) }}?type=combos" class="btn btn-info width-180">Sản phẩm & dịch vu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
