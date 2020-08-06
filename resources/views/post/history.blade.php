<div class="col">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Ngày đăng ký</th>
            <th class="text-white text-center">Chiến dịch</th>
            {{--<th class="text-white text-center">Nội dung tin</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($customer_post as $k => $item)
            <tr>
                <td class="text-center">{{$k+1}}</td>
                <td class="text-center">{{$item->created_at}}</td>
                <td class="text-center">{{@$item->post->campaign->name}}</td>
                {{--<td class="text-center">{{@$item->message}}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $customer_post->total() . ' tin nhắn ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $customer_post->appends(['search' => request()->search ])->links() }}
    </div>
</div>
