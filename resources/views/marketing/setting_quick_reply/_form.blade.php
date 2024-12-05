@extends('layout.app')
@section('content')
    <link href="{{asset('assets/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css"/>

    <div class="card">
        <div class="card-header fix-header bottom-card add-paginate">
            <div class="row" style="width: 100%;">
                <h4 class="col-lg-3">{{isset($docs) ? "CẬP NHẬT TRẢ LỜI NHANH" : "THÊM MỚI TRẢ LỜI NHANH"}}</h4>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                {{--                                {!! Form::open(array('url' => url()->current(), 'method' => 'post', 'files'=> true, 'id'=>'validateForm','autocomplete'=>'off')) !!}--}}
                @if (isset($docs))
                    {!! Form::model($docs, array('url' => url('/marketing/setting-quick-reply/'.$docs->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
                @else
                    {!! Form::open(array('url' => url()->current(), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                @endif
                <div class="modal-body row value-form">
                    <div class="col-md-12">
                        {!! Form::label('shortcut', 'Ký tự tắt', array('class' => 'control-label')) !!}
                        <input type="text" name="shortcut" class="form-control" value="{{isset($docs) ? $docs->shortcut : ''}}">
                        {{--{!! Form::text('shortcut', null, array('class' => 'form-control')) !!}--}}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('message', 'Nội dung', array('class' => 'control-label required')) !!}
                        {{--{!! Form::textarea('message', null, array('class' => 'form-control','rows'=>4)) !!}--}}
                        <textarea name="message" class="form-control" cols="30" rows="4">{{isset($docs) ? $docs->message : ''}}</textarea>
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('images', 'Hình ảnh', array('class' => 'control-label')) !!}
                        <input id="input-100" class="ngon-ngay" name="input24[]" type="file" accept="image/*" multiple>
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



@endsection
@section('_script')
    <script src="{{asset('assets/js/fileinput.min.js')}}"></script>

    <script>

        $(function () {
            $("#input-100").fileinput({
                uploadUrl: "/file-upload-batch/1",
                uploadAsync: false,
                minFileCount: 1,
                maxFileCount: 3,
                overwriteInitial: false,
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                    showRemove: true,
                },
                initialPreview: [
                    @php
                        $domain  = request()->root();
                        if(isset($docs) && !empty($docs->images)){
                            foreach ($docs->images as $item){
                                @$path = $domain.'/uploads/quick_reply/'.@$item;
                                echo '"'. "<img width=213px height=200px src='$path'> <input type='hidden' name='image[]' value='$item'>".'",';
                            }
                        }
                    @endphp
                ],
                initialPreviewAsData: false, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                initialPreviewDownloadUrl: 'http://kartik-v.github.io/bootstrap-fileinput-samples/samples/{filename}', // includes the dynamic filename tag to be replaced for each config
                initialPreviewConfig: [
                    @php
                        if(isset($docs) && !empty($docs->images)){
                            foreach ($docs->images as $item){
                                echo '{caption: "'.$item.'"},';
                            }
                        }
                    @endphp
                ],

                purifyHtml: true, // this by default purifies HTML data for preview
                uploadExtraData: {
                    img_key: "1000",
                    img_keywords: "happy, places"
                },
                layoutTemplates: {
                    actions: '<div class="file-actions">\n' + ' <div class="file-footer-buttons">\n' + ' {upload} {delete} {zoom} {other}' + ' </div>\n' + ' {drag}\n' + ' <div class="file-upload-indicator" title="{indicatorTitle}"></div>\n' + ' <div class="clearfix"></div>\n' + '</div>',
                    actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"><i class="fa fa-trash"></i></button>\n',
                },
            });

        })

        $('body').on('click', '.kv-file-remove', function () {
            let parent = $(this).closest('.file-preview-frame');
            let next = parent.next('.kv-zoom-cache');
            parent.remove();
            next.remove();
        });
    </script>
@endsection