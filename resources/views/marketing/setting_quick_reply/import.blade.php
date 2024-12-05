<div class="modal fade text-left" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title" id="myModalLabel"> Import sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => url('/marketing/setting-quick-reply/import/'.$page_id), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}
            <div class="modal-body row value-form">
                <div class="col-md-6 fileupload fileupload-new mt-1" data-provides="fileupload">
                    <div class="d-flex justify-content-center mb-1" style="margin-top: 10px;">
                        <button type="button" class="btn btn-secondary btn-file">
                            <span class="fileupload-new"><i class="fa fa-file-excel-o"></i> Chọn file</span>
                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                            <input type="file" id="image" name="file" class="btn-secondary">
                        </button>
                    </div>

                    <div class="fileupload-new thumbnail"></div>
                    <div class="fileupload-preview fileupload-exists thumbnail"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-danger" href="{{asset('default/quick_replies.xlsx')}}"><i style="color:red" class="fa fa-cloud-download"> Tải mẫu</i></a>
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-cloud-upload"> Tải lên</i></button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-refresh"> Làm lại</i></button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

