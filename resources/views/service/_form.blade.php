@extends('layout.app')
@section('content')
    <link href="{{asset('assets/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('services/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('services.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên dịch vụ', array('class' => ' required')) !!}
                        {!! Form::text('name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                @if(isset($doc))
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('code', 'Mã dịch vụ', array('class' => ' required')) !!}
                            {!! Form::text('code',null, array('class' => 'form-control','readonly'=>true, 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12 col-md-6">
                    </div>
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('price_buy') ? 'has-error' : '' }}">
                        {!! Form::label('price_buy', 'Giá nhập', array('class' => ' required')) !!}
                        {!! Form::text('price_buy',null, array('class' => 'form-control number')) !!}
                        <span class="help-block">{{ $errors->first('price_buy', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('price_sell') ? 'has-error' : '' }}">
                        {!! Form::label('price_sell', 'Giá bán', array('class' => ' required')) !!}
                        {!! Form::text('price_sell',null, array('class' => 'form-control number', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('price_sell', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('promotion_price') ? 'has-error' : '' }}">
                        {!! Form::label('promotion_price', 'Giá khuyến mại', array('class' => ' required')) !!}
                        {!! Form::text('promotion_price',null, array('class' => 'form-control number')) !!}
                        <span class="help-block">{{ $errors->first('promotion_price', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('trademark') ? 'has-error' : '' }}">
                        {!! Form::label('trademark', 'Nhà cung cấp', array('class' => ' required')) !!}
                        {!! Form::text('trademark',null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('trademark', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                        {!! Form::label('enable', 'Trạng thái', array('class' => ' required')) !!}
                        {!! Form::select('enable',[1 => 'Kinh doanh',0 => 'Ngừng kinh doanh'], null, array('class' => 'form-control select2', 'data-placeholder' => '')) !!}
                        <span class="help-block">{{ $errors->first('enable', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        {!! Form::label('category_id','Danh mục', array('class' => 'required')) !!}
                        {!! Form::select('category_id',$category_pluck, @$doc->category_id, array('class' => 'form-control select2','required'=>true)) !!}
                        <span class="help-block">{{ $errors->first('category_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Mô tả', array('class' => ' required')) !!}
                        {!! Form::textArea('description', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('enable', ':message') }}</span>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label for="input-24">Tải ảnh </label>
                    <input type="file" id="input-100" name="img_file[]" accept="image/*" multiple>
                </div>
            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('services.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('assets/js/jquery.number.min.js')}}"></script>
    <script src="{{asset('assets/js/fileinput.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.number').number(true);
            $("#fvalidate").validate({
                rules: {
                    name: 'required',
                    code: 'required',
                    price_sell: 'required',
                    category_id: 'required',
                },
                messages: {
                    name: "vui lòng nhâp tên dịch vụ",
                    code: "vui lòng nhâp mã dịch vụ",
                    price_sell: "vui lòng nhâp giá bán",
                    category_id: "vui lòng chọn danh mục dịch vụ",
                }
            });

        })
        //Upload multiple image
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
                        $domain     = request()->root();
                        if(isset($doc) && !empty($doc->images)){
                            foreach (@$doc->images as $item){
                                @$path = $domain.'/uploads/services/'.@$item;
                                echo '"'. "<img width=213px height=200px src='$path'> <input type='hidden' name='image[]' value='$item'>".'",';
                            }
                        }
                    @endphp
                    // // IMAGE DATA
                ],
                initialPreviewAsData: false, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                initialPreviewDownloadUrl: 'http://kartik-v.github.io/bootstrap-fileinput-samples/samples/{filename}', // includes the dynamic filename tag to be replaced for each config
                initialPreviewConfig: [
                    @php
                        $domain     = request()->root();
                        if(isset($doc) && !empty($doc->images)){
                            foreach (@$doc->images as $item){
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

            $('body').on('click', '.kv-file-remove', function () {
                var parent = $(this).closest('.file-preview-frame');
                var next = parent.next('.kv-zoom-cache');
                parent.remove();
                next.remove();
            });

        })
    </script>
@endsection
