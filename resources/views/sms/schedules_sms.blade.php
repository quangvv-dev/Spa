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
        {!! Form::open(array('url' => route('sms.saveSchedules'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
        <div class="col row">
            <div class="col-md-8 col-xs-12">
                <div class="col row">
                    <div class="col-12 form-group">
                        {!! Form::label('sms_group', 'Nội dung tin nhắn KH đặt lịch', array('class' => ' required')) !!}
                        {!! Form::textArea('sms_schedules', setting('sms_schedules'), array('class' => 'form-control textarea-custom autocomplete-textarea','id'=>'sms_schedules','maxlength'=>152)) !!}
                        <span class="help-block">Lưu ý nội dung tin nhắn không dấu<br>
                        Nhấn <b>@</b> để chọn biến</span>
                    </div>
                </div>
                <div class="col bot" style="margin-top: 5px">
                    <button type="submit" class="btn btn-success">Lưu</button>
                </div>
            </div>
            {{--<div class="col-md-4 col-xs-12">--}}
                {{--<table class="table card-table table-center text-nowrap table-primary">--}}
                    {{--<thead class="bg-primary text-white">--}}
                    {{--<tr>--}}
                        {{--<th class="text-white text-center">Tên biến</th>--}}
                        {{--<th class="text-white text-center">Ý nghĩa</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td class="text-center">%full_name%</td>--}}
                        {{--<td class="text-center">Tên khách hàng</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        </div>

        {{ Form::close() }}
    </div>
</div>
@section('_script')

@endsection
