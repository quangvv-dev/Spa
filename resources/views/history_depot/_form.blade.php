<div class="modal fade text-left" id="add_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title" id="myModalLabel"> Nhập, xuất kho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => route('depots.history.store'), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}
            <div class="modal-body row value-form">
                <div class="col-md-6">
                    <div class="col">
                        {!! Form::label('depot_id', 'Mã', array('class' => 'control-label required')) !!}
                        {!! Form::select('depot_id', $deposts, null, array('id'=>'depot_id','class' => 'form-control square','placeholder'=>'--Chọn kho--')) !!}
                    </div>
                    <div class="col">
                        {!! Form::label('status', 'Nghiệp vụ kho', array('class' => 'control-label required')) !!}
                        {!! Form::select('status', $status, null, array('id'=>'status','class' => 'form-control square','placeholder'=>'--Nghiệp vụ kho--')) !!}
                    </div>
                    <div class="col">
                        {!! Form::label('note', 'Ghi chú', array('class' => 'control-label required')) !!}
                        {!! Form::text('note', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col">
                        {!! Form::label('', 'Sản phẩm', array('class' => 'control-label required')) !!}
{{--                        {!! Form::select('product_id', $products, null, array('id'=>'product_id','class' => 'form-control square select2','placeholder'=>'--Chọn sản phẩm--')) !!}--}}
                        <select name="product_id" id="product_id" class="products form-control square select2" data-placeholder="--Chọn sản phẩm--">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col" style="margin-top: 10px">
                        <table class="table table-bordered">
                            <tbody class="list-product">
                            </tbody>
                        </table>
                    </div>
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

