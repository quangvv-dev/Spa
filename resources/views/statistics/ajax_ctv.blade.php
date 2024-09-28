<div class="table-responsive" id="registration-form">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Tên</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Thực thu</th>
            <th class="text-white text-center">Hoa hồng CTV</th>
            <th class="text-white text-center">Tổng khách GT</th>
            <th class="text-white text-center">Thao tác</th>

        </tr>

        </thead>
        <tbody>
        @forelse($ctv as $key=>$item)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td class="text-center">
                    {{$item->full_name}}
                    <br>
                    <span class="small-tip">12341234</span>

                </td>
                <td class="text-center">{{number_format($item->doanh_so)}}</td>
                <td class="text-center">{{number_format($item->doanh_thu)}}</td>
                <td class="text-center">{{number_format($item->doanh_thu_ctv)}}</td>
                <td class="text-center">{{$item->total_khach_gt}}</td>
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

