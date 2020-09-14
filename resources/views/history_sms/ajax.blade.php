<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">Nội dung</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td class="text-center">{{@$s->created_at}}</td>
                    <td class="text-center">{{isset($s->campaign)?$s->campaign->name:'Tin Automation'}}</td>
                    <td class="text-center">{{@$s->phone}}</td>
                    <td class="text-center">{{@str_limit($s->message,70)}}</td>
                   </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' tin nhắn đã gửi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

