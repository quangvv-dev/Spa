<div class="table-responsive" style="padding: 5px">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        @if(count($docs))
            @foreach($docs as $item)
                <div class="col-md-12 content_msg padding" style="border-top: 1px solid #c0c3c8;">
                    <div class="col row">
                        <div class="col-md-11">
                            <p>
                                <a href="#" class="bold blue">{{isset($item->user)?$item->user->full_name:''}}</a>
                                <span><i class="fa fa-clock"> {{$item->created_at}}</i></span>
                            </p>
                            <div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                    <i class="fas fa-edit btn-edit-comment" data-id="{{$item->id}}"></i>
                                </a>
                                <a data-original-title="Xóa" rel="tooltip">
                                    <i class="fas fa-trash-alt btn-delete-comment" data-id="{{$item->id}}"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-11 comment">
                            {!! $item->messages !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </table>
</div>

