<div class="modal fade text-left" id="modalSourceFB" tabindex="-1" role="dialog" aria-labelledby="modalFanpagePost"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title" id="myModalLabel">Thêm mới nguồn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => route('marketing.source-landipage.store'), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}
            <div class="modal-body row value-form">
                <div class="col-12">
                    {!! Form::label('name', 'Tên nguồn dữ liệu', array('class' => 'control-label required ')) !!}
                    {!! Form::text('name', null, array('class' => 'form-control square name','required'=>true)) !!}
                </div>
                <div class="col-12">
                    {!! Form::label('url_source', 'Url nguồn dữ liệu', array('class' => 'control-label required')) !!}
                    {!! Form::text('url_source', null, array('class' => 'form-control url_source','required'=>true)) !!}
                </div>

                <div class="col-12">
                    {!! Form::label('chanel', 'Kênh quảng cáo', array('class' => 'control-label')) !!}
                    <select name="chanel" class="select2 form-control chanel-source">
                        <option value="1">Google Ads</option>
                        <option value="2">Facebook Ads</option>
                        <option value="3">Zalo Ads</option>
                        <option value="4">Tiktok Ads</option>
                    </select>
                </div>

                <div class="col-12">
                    {!! Form::label('sale_id', 'Ưu tiên sale', array('class' => 'control-label')) !!}
                    {!! Form::select('sale_id[]', $sales,null, array('class' => 'select2 form-control sale_id','multiple'=>true)) !!}
                </div>
                <div class="col-12">
                    {!! Form::label('category_id', 'Nhóm dịch vụ', array('class' => 'control-label required')) !!}
                    {!! Form::select('category_id[]', $categories,null, array('class' => 'select2 form-control category_id','required'=>true,'multiple'=>true)) !!}
                </div>
                <div class="col-12">
                    {!! Form::label('branch_id', 'Chọn chi nhánh', array('class' => 'control-label required')) !!}
                    {!! Form::select('branch_id', $branch_ids,null, array('class' => 'select2 form-control branch_id','required'=>true)) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"> Lưu</i></button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-refresh"> Làm lại</i></button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
