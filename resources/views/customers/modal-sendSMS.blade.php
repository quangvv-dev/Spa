<div class="modal fade" id="modalSendSMS" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h5>Gửi tin nhắn khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('sms.sentCustomer'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">

                    <div class="col-md-12">
                        <i style="color: red">Nội dung gửi tin</i><br>
                        <textarea class="form-control autocomplete-textarea" id="sms_group" maxlength="152" name="sms_group" rows="5"></textarea>
                    </div>

                    <input type="hidden" name="customer_id" value="{{@$customer->id}}">

                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-primary">gửi tin</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
