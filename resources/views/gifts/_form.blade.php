<div class="modal fade modal-custom text-left" id="addGifts" role="dialog" aria-labelledby="myModalLabel35"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title-custom linear-text fs-24" id="myModalLabel"> Tặng quà</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => route('gifts.store'), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}
            <div class="modal-body value-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col">
                            {!! Form::label('', 'Sản phẩm', array('class' => 'control-label required')) !!}
                            <select id="product_id" class="products form-control square select2"
                                    data-placeholder="--Chọn sản phẩm--">
                                @forelse($products as $key => $pro)
                                    <option value="{{$key}}">{{$pro}}</option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <input type="hidden" name="customer_id" value="{{$order->member_id}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col" style="margin-top: 10px">
                            <table class="table table-bordered">
                                <tbody class="list-product">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"> Lưu</i></button>
                <button type="reset" class="btn btn-warning" data-dismiss="modal">
                    <i class="fa fa-refresh"> Làm lại</i></button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

