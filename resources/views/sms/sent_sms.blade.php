<style>
    label.required:after {
        content: " *";
        color: red;
    }
    ul#textcomplete-dropdown-1 {
        max-height: 300px;
        overflow: auto;
    }
</style>
<div class="col-md-12 col-lg-12">
    <div class="card">
        {!! Form::open(array('url' => route('sms.sent'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
        <div class="col row">
            <div class="col-md-12 col-xs-12">
                <div class="col row">
                    <div class="col-3 form-group">
                        {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required control-label')) !!}
                        {!! Form::select('branch_id', $branchs, null, array('class' => 'form-control select2','id'=>'branch_id', 'required' => true, 'placeholder'=>'Chọn chi nhánh',)) !!}
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                    <div class="col-3 form-group">
                        {!! Form::label('campaign_id', 'Chiến dịch', array('class' => ' required control-label')) !!}
                        {!! Form::select('campaign_id', $campaign_arr, null, array('class' => 'form-control select2','id'=>'campaign_id', 'required' => true, 'placeholder'=>'Chọn chiến dịch',)) !!}
                        <span class="help-block">{{ $errors->first('campaign_id', ':message') }}</span>
                    </div>
                    <div class="col-3 form-group">
                        {!! Form::label('category_id', 'Nhóm khách hàng', array('class' => ' required control-label')) !!}
                        {!! Form::select('category_id[]', $category, null, array('class' => 'form-control select2','multiple'=>true,'id'=>'category_id', 'required' => true, 'data-placeholder'=>'Nhóm KH',)) !!}
                        <span class="help-block">{{ $errors->first('category_id', ':message') }}</span>
                    </div>
                    <div class="col-3 form-group">
                        {!! Form::label('status_id', 'Trạng thái', array('class' => ' required control-label')) !!}
                        {!! Form::select('status_id[]', $status, null, array('class' => 'form-control select2','multiple'=>true,'id'=>'status_id', 'required' => true, 'data-placeholder'=>'Trạng thái',)) !!}
                        <span class="help-block"
                              id="message_status">{{ $errors->first('status_id', ':message') }}</span>
                    </div>
                    <div class="col-3 form-group required {{ $errors->has('time_from') ? 'has-error' : '' }}">
                        {!! Form::label('time_from', 'Ngày tạo KH (từ ngày)') !!}
                        <div class="wd-200 mg-b-30">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                {!! Form::text('time_from', null, array('class' => 'form-control fc-datepicker','id'=>'time_from')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-3 form-group required {{ $errors->has('time_from') ? 'has-error' : '' }}">
                        {!! Form::label('time_to', 'Ngày tạo KH (tới ngày) ') !!}
                        <div class="wd-200 mg-b-30">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                {!! Form::text('time_to', null, array('class' => 'form-control fc-datepicker','id'=>'time_to')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label('limit', 'Giới hạn tin gửi (để trống nếu gửi tất cả )', array('class' => 'control-label')) !!}
                        {!! Form::number('limit',null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('limit', ':message') }}</span>
                    </div>
                    <div class="col-12 form-group">
                        {!! Form::label('sms_group', 'Nội dung tin nhắn', array('class' => ' required')) !!}
                        {!! Form::textArea('sms_group', setting('sms_group'), array('class' => 'form-control autocomplete-textarea','id'=>'sms_group','maxlength'=>152)) !!}
                        <span class="help-block">Lưu ý nội dung tin nhắn không dấu</span>
                    </div>
                </div>
                <div class="col bot" style="margin-top: 5px">
                    <button type="submit" class="btn btn-primary">Gửi tin</button>
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
@section('_script')
    <script src="{{asset('js/jquery.textcomplete.min.js')}}"></script>
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

            $('.autocomplete-textarea').textcomplete([{
                match: /(^|\s)@(\w*(?:\s*\w*))$/,
                search: function (query, callback) {
                    let data = [{
                        name: "Tên khách hàng",
                        value: "%full_name%"
                    }, {
                        name: "SĐT khách hàng",
                        value: "%phone%"
                    }, {
                        name: "Chi nhánh",
                        value: "%branch%"
                    }, {
                        name: "SĐT chi nhánh",
                        value: "%phoneBranch%"
                    },{
                        name: "Địa chỉ chi nhánh",
                        value: "%addressBranch%"
                    }];
                    callback(data);
                },

                template: function (hit) {
                    // phan hien thi o dropdown
                    let html = `
            <a class="tag-item" href="">
            <span class="label">${hit.name} <img width="30" src='{{asset('/assets/images/brand/logo.png')}}'/></span>
            </a>`;
                    return html;
                },

                replace: function (hit) {
                    // phan hien thi khi
                    return hit.value.trim();
                }
            }]);

            $('#branch_id,#status_id,#category_id,#time_to,#time_from').change(function () {
                const status = $('#status_id').val();
                const category = $('#category_id').val();
                const branch = $('#branch_id').val();
                const time_from = $('#time_from').val();
                const time_to = $('#time_to').val();
                $.ajax({
                    url: "{{ Url('ajax/count-customer') }}",
                    method: "get",
                    data: {
                        branch_id: branch,
                        status_id: status,
                        category_id: category,
                        time_from: time_from,
                        time_to: time_to,
                    }
                }).done(function (data) {
                    console.log(data)
                    $('#message_status').html('Hiện có ' + data + ' khác hàng thuộc nhóm !!!');

                });
            })
        })
    </script>
@endsection
