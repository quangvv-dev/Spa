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
                            @if (Auth::user()->id == $item->user_id)
                                <div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                    <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                        <i class="fas fa-edit btn-edit-comment" data-id="{{$item->id}}"></i>
                                    </a>
                                    <a data-original-title="Xóa" rel="tooltip">
                                        <i class="fas fa-trash-alt btn-delete-comment" data-id="{{$item->id}}"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-11 comment" style="white-space: pre-line;">
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
        @endif
    </table>
</div>

