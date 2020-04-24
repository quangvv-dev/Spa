<style>
    label.required:after {
        content: " *";
        color: red;
    }
</style>
<div class="col-md-12 col-lg-12">
    <div class="card">
        {!! Form::open(array('url' => route('sms.sent'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
        <div class="col row">
            <div class="col-md-6 col-xs-12">
                <div class="col-xs-12 form-group">
                    {!! Form::label('category_id', 'Nhóm khách hàng', array('class' => ' required control-label')) !!}
                    {!! Form::select('category_id', $category, null, array('class' => 'form-control select2','id'=>'category_id', 'required' => true, 'placeholder'=>'Nhóm dịch vụ',)) !!}
                    <span class="help-block">{{ $errors->first('category_id', ':message') }}</span>
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('status_id', 'Trạng thái', array('class' => ' required control-label')) !!}
                    {!! Form::select('status_id', $status, null, array('class' => 'form-control select2','id'=>'status_id', 'required' => true, 'placeholder'=>'Trạng thái',)) !!}
                    <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
                </div>
                <div class="col-xs-12">
                    {!! Form::label('sms_group', 'Nội dung tin nhắn KH đặt lịch', array('class' => ' required')) !!}
                    {!! Form::textArea('sms_group', setting('sms_group'), array('class' => 'form-control','id'=>'sms_group','maxlength'=>152)) !!}
                    <span class="help-block">Lưu ý nội dung tin nhắn không dấu</span>
                </div>
                <div class="col bot" style="margin-top: 5px">
                    <button type="button" class="btn btn-success" id="click-sent">Gửi tin</button>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white text-center">Tên biến</th>
                        <th class="text-white text-center">Ý nghĩa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">%full_name%</td>
                        <td class="text-center">Tên khách hàng</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2 col-xs-12"></div>

        </div>

        {{ Form::close() }}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#click-sent').click(function () {
            swal({
                title: 'Cảnh báo ?',
                text: "Bạn sẽ mất phí khi nhắn tin cho tất cả khác hàng trong nhóm đã chọn!",
                type: "warning",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-warning waves-effect waves-light',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Từ chối',
            }, function () {
                $('form.sent-sms').submit();
            })
        });
    })
</script>
