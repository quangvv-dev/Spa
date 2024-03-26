<style>
    .content_msg{
        background-color: rgb(243 243 243);
        margin: 10px 3px;
        padding: 8px 16px;
        border-radius: 8px;
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
    .label-date{
        color: white;
        background-color: rgb(239, 135, 55);
        padding: 0px 10px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 500;
    }
    .ant-avatar {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        color: rgba(0, 0, 0, .85);
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
        background: #ccc;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
    }
    .ant-timeline-item-tail {
        position: absolute;
        top: 10px;
        left: 4px;
        height: calc(100% - 10px);
        border-left: 2px dotted rgb(179, 179, 179);
    }
    .ant-timeline-item-head-custom {
        position: absolute;
        top: 5.5px;
        left: 5px;
        width: auto;
        height: auto;
        margin-top: 0;
        padding: 3px 1px;
        line-height: 1;
        text-align: center;
        border: 0;
        border-radius: 0;
        transform: translate(-50%, -50%);
    }
    .ant-timeline-item-head-blue {
        color: #1890ff;
        border-color: #1890ff;
    }
    .ant-timeline-item-head{
        background-color: #fff;
    }
</style>

<div class="table-responsive group-comment-table" style="padding: 5px">

    <table class="table card-table table-vcenter text-nowrap table-primary">
        @if(count($docs))
            @foreach($docs as $k => $item)
                {{--                Date--}}
{{--                <div class="ant-divider ant-divider-horizontal ant-divider-with-text ant-divider-with-text-center" role="separator">--}}
{{--                    <span class="ant-divider-inner-text"><div class="label-date">21/03/2024</div></span>--}}
{{--                </div>--}}
                <div class="col-md-12 content_msg padding" style="border-top: 1px solid #c0c3c8;">
                    <div class="ant-timeline-item-head ant-timeline-item-head-custom ant-timeline-item-head-blue">
                        <img src="{{asset('default/comment.png')}}" style="width: 25px; height: 25px;">
                    </div>
{{--                    <div class="ant-timeline-item-tail"></div>--}}
                    <div class="col row">
                        <div class="col-md-11 row" style="align-items: center">
                            <div class="col-md-1">
                                <span class="ant-avatar ant-avatar-circle" style="background-color: rgb(150, 217, 201);">
                                    <span class="ant-avatar-string" style="transform: scale(1) translateX(-50%);">
                                        {{isset($item->user)?substr($item->user->full_name, 0, 1):'N'}}</span>
                                </span>
                            </div>
                            <div class="col-md-11">
                                <p>
                                    <a href="#" class="bold blue">{{isset($item->user)?$item->user->full_name:'Nhân viên bị xóa'}}</a>
                                    <span><i class="fa fa-clock"></i> {{$item->created_at}}</span>
                                </p>
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
                        <div class="col-md-11 comment" style="white-space: pre-line;">
                            <label>Nội dung: </label>
                            {!! $item->messages !!}
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

