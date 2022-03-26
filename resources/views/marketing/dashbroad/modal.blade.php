<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        {!! Form::open(array('url' => 'ajax/marketing/add-line-price-marketing', 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h3 class="modal-title">THÊM DỮ LIỆU CHO LANDING THEO NGÀY</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">Thêm dữ liệu landing</div>
                    <div class="col-5">
                        <input type="hidden" class="form-control square start_date" name="start_date"
                               id="start_date1">
                        <input type="hidden" class="form-control square end_date" name="end_date" id="end_date1">
                        <input id="reportrange1" type="text" class="form-control square">
                    </div>
                    {{--<div class="col-2"><input type="date" class="form-control square end_date"></div>--}}

                    <div class="col-1">
                        <button class="btn btn-primary searchAddLanding"><i class="fa fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
                <div class="tableFixHead table-bordered table-hover mt-2" style="min-height: 70vh;">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Landing</th>
                            <th class="text-center">Kênh quảng cáo</th>
                            <th class="text-center">Ngân sách</th>
                            <th class="text-center">Dữ liệu ngày</th>
                            <th class="text-center">Cập nhật</th>
                            <th class="text-center"><a id="add_new_price_marketing"><i class="fa fa-plus"></i> Thêm</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list-data">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
