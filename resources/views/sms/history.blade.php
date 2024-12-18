<div class="col">
    <table class="table card-table table-center text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Hệ thống gửi</th>
            <th class="text-white text-center">KH nhận</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Nội dung tin</th>
            <th class="text-white text-center" style="max-width: 30px">
                <a data-toggle="modal" data-target="#modalSendSMS"><i style="color: #fff" class="fa fa-plus"></i> Gửi tin</a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($history as $k => $item)
            <tr>
                <td class="text-center">{{$k+1}}</td>
                <td class="text-center">{{@formatYMD($item->created_at)}}</td>
                <td class="text-center">{{@formatYMD($item->updated_at)}}</td>
                <td class="text-center">{{@$item->campaign->name?:'Tin Automation'}}</td>
                <td class="text-center">{{@$item->message}}</td>
                <td class="text-center"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $history->total() . ' tin nhắn ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $history->appends(['search' => request()->search ])->links() }}
    </div>
</div>
