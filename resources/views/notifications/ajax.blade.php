<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap">
        <tbody>
        @if(count($docs))
            @foreach($docs as $doc)
                <tr style="{{$doc->status==\App\Constants\NotificationConstant::UNREAD?'background:#edf2fa':'background:#fff'}}">
                    <td data-id="{{$doc->id}}" data-url="{{'/tasks/' .$doc->task_id . '/edit'}}">
                        <div class="content">{{$doc->title}}</div>
                        <div class="date">{{$doc->created_at}}</div>
                    </td>
                </tr>
            @endforeach

        @else
            <tr>
                Không có thông báo nào !!!
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

