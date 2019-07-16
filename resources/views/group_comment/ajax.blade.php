<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        @if(count($docs))
            @foreach($docs as $item)
                <div class="col-md-12 content_msg padding">
                    <div class="col row">
                        <div class="col-md-11"><p><a href="#" class="bold blue">{{isset($item->user)?$item->user->full_name:''}}</a>
                                <span><i class="fa fa-clock"> {{$item->created_at}}</i></span></p>
                        </div>
{{--                        <div class="col-md-1">--}}
{{--                            <div class="icon" style="float: right">--}}
{{--                                <a><i class="fa fa-edit"></i></a>--}}
{{--                                <a><i class="fa fa-trash"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    {!! $item->messages !!}
                        {{--            <div class="col-md-12">--}}
                        {{--                {!! Form::textArea('messages', null, array('class' => 'messages')) !!}--}}
                        {{--            </div>--}}
                        {{--            <div class="col-md-12" style="float: right">--}}
                        {{--                <button type="submit" class="btn btn-success">Gửi</button>--}}
                        {{--            </div>--}}
                    <br>
                    {{--            <div class="line"></div>--}}
                </div>
            @endforeach
        @endif
    </table>
</div>

