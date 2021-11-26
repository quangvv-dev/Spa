<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap">
        <tbody>
        @if(count($docs))
            @foreach($docs as $doc)
                @php
                    $url = $doc->type == \App\Constants\NotificationConstant::THU_CHI ? '/thu-chi?id='.$doc->data['thu_chi_id'] : '/tasks/' .$doc->task_id . '/edit';
                @endphp
                <tr style="{{$doc->status==\App\Constants\NotificationConstant::UNREAD?'background:#edf2fa':'background:#fff'}}">
                    <td data-id="{{$doc->id}}" data-url="{{$url}}">
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

