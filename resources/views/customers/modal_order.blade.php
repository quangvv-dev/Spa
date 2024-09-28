<!-- Large Modal -->
<div id="largeModal" class="modal fade">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content history-update-order">
            <div class="modal-header pd-x-20">
                <h6 class="modal-title">Lịch sử liệu trình </h6>
                <div class="col-md-3">
                    {!! Form::select('list_service', [], null, array('id'=>'list_service','class' => 'form-control')) !!}
                </div>

                <div class="col-md-3">
                    {!! Form::label('count_service','Số buổi còn lại: ', array('id'=>'count_service')) !!}
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <div class="table-responsive">
                    <table class="table card-table table-bordered table-vcenter text-nowrap table-primary">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-white text-center">STT</th>
                            <th class="text-white text-center">Ngày thực hiện</th>
                            <th class="text-white text-center">Người thực hiện chính</th>
                            <th class="text-white text-center">Người hỗ trợ</th>
                            <th class="text-white text-center">Dịch vụ</th>
                            <th class="text-white text-center">Mô tả</th>
                            <th class="text-white text-center">Loại</th>
                            <th class="text-white text-center">thao tác</th>
                        </tr>
                        </thead>
                        <tbody style="background: white;" class="data-history-update-order">

                        </tbody>
                    </table>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
