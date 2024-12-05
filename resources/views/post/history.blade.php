<div class="col">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Ngày đăng ký</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center"><i class="fa fa-save"></i></th>
        </tr>
        </thead>
        <tbody>
        @foreach($customer_post as $k => $item)
            <tr>
                <td class="text-center">{{$k+1}}</td>
                <td class="text-center">{{$item->created_at}}</td>
                <td class="text-center">{{@$item->post->campaign->name}}</td>
                @if($item->status == 1)
                    <td class="text-center update-status" data-id="{{$item->id}}" style="cursor: pointer">
                        <i class="fa fa-check-square text-primary" aria-hidden="true"></i></td>
                @else
                    <td class="text-center">
                        <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                    </td>
                @endif
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
<script>
    $('.update-status').click(function () {
        const id = $(this).data('id');

        swal({
            title: 'Xác nhận KH đã đến cơ sở ?',
            type: "success",
            cancelButtonClass: 'btn-secondary waves-effect',
            confirmButtonClass: 'btn-success waves-effect waves-light',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Từ chối',
            showCancelButton: true,
        }, function () {
            $.ajax({
                type: 'PUT',
                url: "{{route('customer_post.update')}}",
                data: {
                    ids: [id],
                    status: 2,
                },
                success: function () {
                    window.location.reload();
                }
            })
        })
    });
</script>
