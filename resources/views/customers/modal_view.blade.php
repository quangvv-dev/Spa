<div class="modal fade" id="view_chat" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Trao đổi nhanh</h4>
                <i style="color: red">Xin chào {{Auth::user()->full_name}} tính năng trao đổi nhanh đang được nâng cấp, vui lòng trở lại sau 6h nữa !!! </i>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
{{--                {!! Form::open(array('url' => url('/ajax/view-chat'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}--}}
                <div class="row">
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <div class="chat-flash col-md-12">
                        <div class="white-space">
                            <img width="50" height="50" class="fl mr10 a40 border"
                                 src="{{asset('default/no-image.png')}}" style="border-radius:100%">
                            <a class="bold blue uppercase" href="#/crm/view_account/3428">
                                KH3428 - Mộc Thanh ( khúc phạm) </a> <br> <a class="blue" href="#/users/about/5">@Đàm
                                Ngọc Châu</a></div>
                        <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                            {!! Form::textArea('messages', null, array('class' => 'form-control','rows'=>5)) !!}
                            <span class="help-block">{{ $errors->first('enable', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success"disabled>Lưu</button>
                    </div>
                </div>
{{--                {{ Form::close() }}--}}
                <div class="row" style="margin-top: 10px">
                    <div class="content_msg padding"
                         style="background: aliceblue;margin-left: 10px;width: 95% !important">
                        <div class="col row">
                            <div class="col-md-11"><p><a href="#" class="bold blue">Admin</a>
                                    <span><i class="fa fa-clock"> 2019-09-25 17:52:43</i></span></p>
                            </div>
                        </div>
                        <div>Test hệ thống</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

