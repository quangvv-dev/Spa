<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
<div class="modal fade modal-custom" id="myModalExport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>TẢI DATA DUYỆT CHI</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('thu-chi.export'), 'method' => 'post', 'files'=> true,'enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row" style="width: 100%">
                    <div class="col-md-12">
                        <i style="color: #3ca2e8">Thời gian (*)</i><br>
                        <input type="hidden" name="start_date" id="start_date1">
                        <input type="hidden" name="end_date" id="end_date1">
                        <input id="reportrange1" type="text" class="form-control square">
                    </div>
                    <div class="col-md-12">
                        <i style="color: #3ca2e8">Danh mục chi</i><br>
                        {!! Form::select('category_id', $categories, null, array('class' => 'form-control select2','id'=>'category','placeholder'=>'--Tất cả danh mục--')) !!}
                    </div>
                    <div class="col-md-12">
                        <i style="color: #3ca2e8">Trạng thái duyệt</i><br>
                        <select name="status" id="status" class="form-control">
                            <option value="">--Tất cả trạng thái--</option>
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <i style="color: #3ca2e8">Chi nhánh</i><br>
                        {!! Form::select('branch_id', $branches, null, array('class' => 'form-control select2','id'=>'branch','placeholder'=>'--Tất cả chi nhánh--')) !!}
                    </div><br>
                    <div class="col-md-12">
                        <i style="color: red;font-size: small">Excel được xuất dưới dạng .xlxs (newer 2016)</i><br>
                        <button type="submit" class="btn btn-warning">Xuất Excel</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/daterangepicker.min.js')}}"></script>
<script src="{{asset('js/dateranger-config.js')}}"></script>
