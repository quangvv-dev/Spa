<style>
    .content_msg {
        background-color: #f3f3f3;
        margin: 10px 3px;
        padding: 8px 16px;
        border-radius: 8px;
        border-top: 1px solid #c0c3c8;
    }

    .ant-divider-horizontal.ant-divider-with-text {
        margin: 16px 0;
        color: rgba(0, 0, 0, .85);
        font-weight: 500;
        font-size: 16px;
        white-space: nowrap;
        text-align: center;
        border-top: 0;
        border-top-color: rgba(0, 0, 0, .06);
    }

    .ant-divider-inner-text {
        display: inline-block;
        padding: 0 1em;
    }

    .label-date {
        color: white;
        background-color: #ef8737;
        padding: 0px 10px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 500;
    }

    .ant-avatar {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-size: 14px;
        font-variant: tabular-nums;
        line-height: 1.5715;
        list-style: none;
        font-feature-settings: "tnum", "tnum";
        position: relative;
        display: inline-block;
        overflow: hidden;
        color: #fff;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background-color: rgb(150, 217, 201);
    }

    .group-comment-table{
        overflow-x: hidden;
    }

    .chat-tag-icon {
        position: absolute;
        top: 0;
        left: 0;
        padding: 4px;
    }

    .chat-tag-icon i {
        font-size: 14px;
    }

    .audio-border {
        border: 1px #d7dde09e solid;
        border-radius: 10px;
    }
</style>

<div class="table-responsive group-comment-table" style="padding: 5px">

    <table class="table card-table table-vcenter text-nowrap table-primary">
        @if(count($docs))
            @foreach($docs as $k => $item)
                <div class="col-md-12 content_msg padding">
                    @if(isset($item->status))
                        <div class="chat-tag-icon">
                            <i class="fa fa-tag" style="color: {{@$item->status->color}}"></i>
                        </div>
                    @endif

                    <div class="col row">
                        <div class="col-md-11 row align-items-center">
                            <div class="col-md-1">
                                <span class="ant-avatar ant-avatar-circle">
                                    <span class="ant-avatar-string bold">
                                        {{isset($item->user)?substr($item->user->full_name, 0, 1):'N'}}</span>
                                </span>
                            </div>
                            <div class="col-md-11">
                                @if(isset($item->call))
                                    <p>
                                        <a class="bold blue">{{isset($item->call->user)?$item->call->user->full_name:'Hệ thống'}}</a>
                                        <span><i class="fa fa-clock"></i> {{$item->created_at}}</span>
                                    </p>
                                @else
                                    <p>
                                        <a class="bold blue">{{isset($item->user)?$item->user->full_name:'Hệ thống'}}</a>
                                        <span><i class="fa fa-clock"></i> {{$item->created_at}}</span>
                                    </p>
                                @endif
                            </div>
                            @if (Auth::user()->id == $item->user_id)
                                <div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                    @if(!in_array('comment.edit',setting('permissions')??[]))
                                        <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                            <i class="fas fa-pencil-alt btn-edit-comment" data-id="{{$item->id}}"></i>
                                        </a>
                                    @endif
                                    <a data-original-title="Xóa" rel="tooltip">
                                        <i class="fas fa-trash-alt btn-delete-comment" data-id="{{$item->id}}"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-11 comment" style="margin-top: 10px;align-items: center;display: flex">
                            @if(isset($item->call))
                                <label class="bold">File ghi âm:  </label>
                                <audio controls class="audio-border">
                                    <source src="{{@$item->call->recording_url}}" type="audio/wav">
                                </audio>
                            @else
{{--                                <label class="bold">Nội dung: </label>--}}
                                <span style="font-style: italic">{!! $item->messages !!}</span>
                            @endif
                        </div>
                        @if (isset($item->image))
                            <div class="col-md-11">
                                <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                    <div class="fileupload fileupload-exists"
                                         data-provides="fileupload">
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px">
                                            <a href="{{ $item->image }}" class="mobileLightBox"><img src="{{ $item->image }}" alt="image"/></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
                <div class="pull-right">
                    {{ $docs->links() }}
                </div>
        @endif
    </table>
</div>
