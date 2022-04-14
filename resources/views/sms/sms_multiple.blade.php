<style>
    label.required:after {
        content: " *";
        color: red;
    }

    ul#textcomplete-dropdown-2 {
        max-height: 300px;
        overflow: auto;
    }
</style>
<div class="col-md-12 col-lg-12">
    <div class="card">
        {!! Form::open(array('url' => route('sms.sentMultiple'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
        <div class="col row">
            <div class="col-md-12 row">
                <div class="col-3 form-group">
                    {!! Form::label('list_name', 'Danh sách tên KH', array('class' => ' required')) !!}
                    {!! Form::textArea('list_name', null, array('class' => 'form-control autocomplete-textarea','rows'=>7)) !!}
                    <span
                        class="help-block">Có thể nhập nhiều tên khách hàng cách nhau bằng dấu ";" hoặc xuống dòng</span>
                </div>
                <div class="col-3 form-group">
                    {!! Form::label('list_phone', 'Danh sách SĐT', array('class' => ' required')) !!}
                    {!! Form::textArea('list_phone', null, array('class' => 'form-control autocomplete-textarea','rows'=>7)) !!}
                    <span
                        class="help-block">Có thể nhập nhiều số điện thoại cách nhau bằng dấu ";" hoặc xuống dòng</span>
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('content', 'Nội dung tin nhắn KH đặt lịch', array('class' => ' required')) !!}
                    {!! Form::textArea('content', setting('content_multiple_sms'), array('class' => 'form-control autocomplete-textarea','required'=>true,'rows'=>7)) !!}
                    <span class="help-block">Lưu ý nội dung tin nhắn không dấu</span>
                </div>
            </div>
            <div class="col bot" style="margin-top: 5px">
                <button type="submit" class="btn btn-success">Lưu</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
@section('_script')

@endsection
