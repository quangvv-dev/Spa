<div class="col-md-12 col-lg-12">
    <div class="card">
        {!! Form::open(array('url' => route('sms.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
        <div class="col row">
            <div class="col-md-6 col-xs-12">
{{--                <div class="col-xs-12">--}}
{{--                    {!! Form::label('sms_cskh', 'Nội dung tin nhắn KH đặt lịch', array('class' => ' required')) !!}--}}
{{--                    {!! Form::text('sms_cskh', setting('sms_cskh'), array('class' => 'form-control')) !!}--}}
{{--                    <span class="help-block">{{ $errors->first('note', ':message') }}</span>--}}
{{--                </div>--}}
                <div class="col">
                    {!! Form::label('name', 'Tên chiến dịch', array('class' => ' required')) !!}
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>true)) !!}
                    <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                </div>
                {{--                <div class="col-xs-12">--}}
{{--                    {!! Form::label('sms_csnv', 'Nội dung tin nhắn báo nhân viên CSKH', array('class' => ' required')) !!}--}}
{{--                    {!! Form::text('sms_csnv', setting('sms_csnv'), array('class' => 'form-control')) !!}--}}
{{--                    <span class="help-block">{{ $errors->first('note', ':message') }}</span>--}}
{{--                </div>--}}
{{--                <div class="col-xs-12">--}}
{{--                    {!! Form::label('sms_cskh_booking', 'Nội dung tin nhắn cám ơn KH đã sử dụng dịch vụ', array('class' => ' required')) !!}--}}
{{--                    {!! Form::text('sms_cskh_booking', setting('sms_cskh_booking'), array('class' => 'form-control')) !!}--}}
{{--                    <span class="help-block">{{ $errors->first('sms_cskh_booking', ':message') }}</span>--}}
{{--                </div>--}}
{{--                <div class="col-xs-12">--}}
{{--                    {!! Form::label('sms_birthday_kh', 'Nội dung tin nhắn mừng sinh nhật KH', array('class' => ' required')) !!}--}}
{{--                    {!! Form::text('sms_birthday_kh', setting('sms_birthday_kh'), array('class' => 'form-control')) !!}--}}
{{--                    <span class="help-block">{{ $errors->first('note', ':message') }}</span>--}}
{{--                </div>--}}
            </div>
            <div class="col-md-6 col-xs-12">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white text-center">ID</th>
                        <th class="text-white text-center">Chiến dịch</th>
                        <th class="text-white text-center">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($campaign))
                        @foreach($campaign as $item)
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td class="text-center">{{@$item->name}}</td>
                            </tr>
                        @endforeach
                    @endif

{{--                    <tr>--}}
{{--                        <td class="text-center">%time_from%</td>--}}
{{--                        <td class="text-center">Thời gian đặt lịch (từ)</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="text-center">%time_to%</td>--}}
{{--                        <td class="text-center">Thời gian đặt lịch (tới)</td>--}}
{{--                    </tr>--}}
                    </tbody>
                </table>
                <div class="pull-left">
                    <div class="page-info">
                        {{ 'Tổng số ' . $campaign->total() . ' chiến dịch ' . (request()->search ? 'found' : '') }}
                    </div>
                </div>
                <div class="pull-right">
                    {{ $campaign->appends(['search' => request()->search ])->links() }}
                </div>
            </div>
            <div class="col bot" style="margin-top: 5px">
                <button type="submit" class="btn btn-success">Lưu</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
