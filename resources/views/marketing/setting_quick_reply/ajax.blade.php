<div id="registration-form" class="table-responsive tableFixHead table-bordered table-hover">
    <table class="table">
        <thead>
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Shortcut</th>
            <th class="text-center">Tin nhắn</th>
            <th class="text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @forelse($docs as $key=>$item)
        <tr>
            <td class="text-center">{{$key+1}}</td>
            <td class="text-center">{{$item->shortcut}}</td>
            <td class="text-center">{{$item->message}}</td>
            <td class="text-center">
                <a href="{{asset('marketing/setting-quick-reply/'.$item->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                <a class="btn delete-item" href="javascript:void(0)" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
            @empty
        @endforelse
        </tbody>
    </table>
    <div class="float-right">
        {{$docs->links()}}
    </div>
</div>
