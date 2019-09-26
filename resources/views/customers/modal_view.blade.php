<div class="modal fade" id="view_chat" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Trao đổi nhanh</h4>
                <i style="color: red">Xin chào {{Auth::user()->full_name}} tính năng trao đổi nhanh đang được nâng cấp,
                    vui lòng trở lại sau 6h nữa !!! </i>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{--{!! Form::open(array('method' => 'post')) !!}--}}
                <div class="row">
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <div class="chat-flash col-md-12">
                        <div class="white-space" style="display: flex; align-items: center;">
                            <img width="50" height="50" class="fl mr10 a40 border"
                                 src="{{asset('default/no-image.png')}}" style="border-radius:100%">
                            <a class="bold blue uppercase user-name" href="javascript:void(0);" style="margin-left: 5px">
                            </a></div>
                        <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                            {!! Form::textArea('messages', null, array('class' => 'form-control', 'rows'=> 5, 'required' => 'required')) !!}
                            <span class="help-block">{{ $errors->first('enable', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success" id="chat-save">Lưu</button>
                    </div>
                </div>
                {{--{{ Form::close() }}--}}
                <div class="row" style="margin-top: 10px">
                    <div class="content-msg padding"
                         style="background: aliceblue;margin-left: 10px;width: 95% !important">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

