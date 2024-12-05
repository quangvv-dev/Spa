<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 90vh;overflow-y: auto">
            <div class="modal-header">
                <h4>Chi tiết đơn hàng nhận hoa hồng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table card-table table-center text-nowrap table-primary">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-white">STT</th>
                            <th class="text-white text-center">Ngày tạo đơn</th>
                            <th class="text-white text-center">Hoa hồng</th>
                            <th class="text-white text-center">Doanh số</th>
                            <th class="text-white text-center">Doanh thu</th>
                        </tr>
                        </thead>
                        <tbody id="get_data">

                        </tbody>
                    </table>
                    <div class="pull-right">
                        <ul class="pagination" role="navigation">
                            {{--<li class="page-item active" aria-current="page"><span class="page-link">1</span></li>--}}

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


