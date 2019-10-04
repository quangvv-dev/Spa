<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        @if(count($docs))
            @foreach($docs as $item)
                <div class="col-md-12 content_msg padding">
                    <div class="col row">
                        <div class="col-md-11"><p><a href="#" class="bold blue">{{isset($item->user)?$item->user->full_name:''}}</a>
                                <span><i class="fa fa-clock"> {{$item->created_at}}</i></span></p>
                        </div>
                    </div>
                    {!! $item->messages !!}
                    <br>
                </div>
            @endforeach
        @endif
    </table>
</div>

