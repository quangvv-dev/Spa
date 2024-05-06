<div class="table-responsive" id="registration-form">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên</th>
            <th class="text-white text-center">Tổng khách GT</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Thực thu</th>
            <th class="text-white text-center">Hoa hồng CTV</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        @if(count($ctv))
            <tr>
                <td class="text-center bold" colspan="2">TỔNG</td>
                <td class="text-center bold">{{$ctv->sum('total_khach_gt')}}</td>
                <td class="text-center bold">{{$ctv->sum('don_hang')}}</td>
                <td class="text-center bold">{{number_format($ctv->sum('doanh_so'))}}</td>
                <td class="text-center bold">{{number_format($ctv->sum('doanh_thu'))}}</td>
                <td class="text-center bold">{{number_format($ctv->sum('doanh_thu_ctv'))}}</td>
                <td class="text-center bold">
                </td>
            </tr>
        @endif
        </thead>
        <tbody>
        @forelse($ctv as $key=>$item)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td class="text-center">
                    {{$item->full_name}}<br>
                    <span class="small-tip">({{$item->account_code}})</span>
                </td>
                <td class="text-center">{{$item->total_khach_gt}}</td>
                <td class="text-center">{{$item->don_hang}}</td>
                <td class="text-center">{{number_format($item->doanh_so)}}</td>
                <td class="text-center">{{number_format($item->doanh_thu)}}</td>
                <td class="text-center">{{number_format($item->doanh_thu_ctv)}}</td>
                <td class="text-center">
                    <i class="fa fa-save showDetail" style="cursor: pointer" title="Chi tiết"></i>
                </td>
            </tr>
        @empty
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . 10 . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{--{{ $docs->appends(['search' => request()->search ])->links() }}--}}
    </div>
</div>

