<div class="modal fade modal-custom text-left" id="modalFanpagePost" tabindex="-1" role="dialog" aria-labelledby="modalFanpagePost"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title-custom linear-text fs-24" id="myModalLabel"> Nhập bài viết quảng cáo (thủ công)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => route('marketing.fanpage_post.storeCustom'), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}
            <div class="modal-body row value-form">
                <div class="col-md-6">
                    {!! Form::label('page_id', 'Fanpage', array('class' => 'control-label required')) !!}
                    {!! Form::select('page_id', $my_page, null, array('class' => 'form-control square select2','required'=>true,'data-placeholder'=>'--Chọn fanpage--')) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('post_id', 'ID bài viết', array('class' => 'control-label required')) !!}
                    {!! Form::text('post_id', null, array('class' => 'form-control square','id'=>'phone','required'=>true)) !!}
                    <label id="phone-error" class="error" for="phone"></label>
                </div>
                <div class="col-md-6">
                    {!! Form::label('title', 'Nội dung (Tiêu để bài viết)', array('class' => 'control-label')) !!}
                    {!! Form::textArea('title', null, array('class' => 'form-control square','required'=>true)) !!}
                    <label id="email-error" class="error" for="email"></label>

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
