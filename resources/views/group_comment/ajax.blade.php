@if(count($docs))
    @php
        $count = count($docs) - 1;
    @endphp
    @foreach($docs as $k => $item)

        <div class="item {{$k%2==0 ? 'high-light' : ''}} {{$count == $k ? 'last-item' : ''}}">
            @if(isset($item->status))
                <div class="chat-tag-icon">
                    <i class="fa fa-tag" style="color: {{@$item->status->color}}"></i>
                </div>
            @endif
            <div class="d-flex align-items-center gap-8">
                {{--<img src="{{asset('layout/images/Ava.png')}}" width="40" height="40" alt="">--}}
                <span class="ant-avatar ant-avatar-circle">
                            <span class="ant-avatar-string bold">{{isset($item->user)?substr($item->user->full_name, 0, 1):'N'}}</span>
                        </span>
                <div>
                    @if(isset($item->call))
                        <div class="fs-16">{{isset($item->call->user)?$item->call->user->full_name:'Hệ thống'}}</div>
                    @else
                        <div class="fs-16">{{isset($item->user)?$item->user->full_name:'Hệ thống'}}</div>
                    @endif

                    {{--<div class="fs-12 color-dark font-svn-small">Leader Telesale Dr Tiến</div>--}}
                </div>
                <div class="color-dark time font-svn-small">{{$item->created_at}}</div>
            </div>
            <div class="fs-16 d-flex align-items-center gap-8" style="padding-left: 48px;">
                @if(isset($item->call))
                    <label class="bold">File ghi âm:  </label>
                    <audio controls class="audio-border">
                        <source src="{{@$item->call->recording_url}}" type="audio/wav">
                    </audio>
                @else
                    {!! $item->messages !!}
                @endif
                    @if (isset($item->image))
                        <div class="col-md-11">
                            <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                <div class="fileupload fileupload-exists"
                                     data-provides="fileupload">
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px">
                                        <a href="{{ $item->image }}" class="mobileLightBox"><img src="{{ $item->image }}"
                                                                                                 alt="image"/></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        </div>





        {{--<div class="col-md-12 content_msg padding">--}}
            {{--@if(isset($item->status))--}}
                {{--<div class="chat-tag-icon">--}}
                    {{--<i class="fa fa-tag" style="color: {{@$item->status->color}}"></i>--}}
                {{--</div>--}}
            {{--@endif--}}

            {{--<div class="col row">--}}
                {{--<div class="col-md-11 row align-items-center">--}}
                    {{--<div class="col-md-1">--}}
        {{--<span class="ant-avatar ant-avatar-circle">--}}
        {{--<span class="ant-avatar-string bold">--}}
        {{--{{isset($item->user)?substr($item->user->full_name, 0, 1):'N'}}</span>--}}
        {{--</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-11">--}}
                        {{--@if(isset($item->call))--}}
                            {{--<p>--}}
                                {{--<a class="bold blue">{{isset($item->call->user)?$item->call->user->full_name:'Hệ thống'}}</a>--}}
                                {{--<span><i class="fa fa-clock"></i> {{$item->created_at}}</span>--}}
                            {{--</p>--}}
                        {{--@else--}}
                            {{--<p>--}}
                                {{--<a class="bold blue">{{isset($item->user)?$item->user->full_name:'Hệ thống'}}</a>--}}
                                {{--<span><i class="fa fa-clock"></i> {{$item->created_at}}</span>--}}
                            {{--</p>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--@if (Auth::user()->id == $item->user_id)--}}
                        {{--<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">--}}
                            {{--@if(!in_array('comment.edit',setting('permissions')??[]))--}}
                                {{--<a data-original-title="Sửa" rel="tooltip" style="margin-right: 5px">--}}
                                    {{--<i class="fas fa-pencil-alt btn-edit-comment" data-id="{{$item->id}}"></i>--}}
                                {{--</a>--}}
                            {{--@endif--}}
                            {{--<a data-original-title="Xóa" rel="tooltip">--}}
                                {{--<i class="fas fa-trash-alt btn-delete-comment" data-id="{{$item->id}}"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="col-md-11 comment" style="margin-top: 10px;align-items: center;display: flex">--}}
                    {{--@if(isset($item->call))--}}
                        {{--<label class="bold">File ghi âm: </label>--}}
                        {{--<audio controls class="audio-border">--}}
                            {{--<source src="{{@$item->call->recording_url}}" type="audio/wav">--}}
                        {{--</audio>--}}
                    {{--@else--}}
                        {{--<label class="bold">Nội dung: </label>--}}
                        {{--<span style="font-style: italic">{!! $item->messages !!}</span>--}}
                    {{--@endif--}}
                {{--</div>--}}
{{--                @if (isset($item->image))--}}
{{--                    <div class="col-md-11">--}}
{{--                        <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">--}}
{{--                            <div class="fileupload fileupload-exists"--}}
{{--                                 data-provides="fileupload">--}}
{{--                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px">--}}
{{--                                    <a href="{{ $item->image }}" class="mobileLightBox"><img src="{{ $item->image }}"--}}
{{--                                                                                             alt="image"/></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            {{--</div>--}}
        {{--</div>--}}
    @endforeach
    <div class="pull-right">
        {{ $docs->links() }}
    </div>
@endif
