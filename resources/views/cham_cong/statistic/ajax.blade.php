<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" rowspan="2">TT</th>
            <th class="text-center" rowspan="2">Mã NV</th>
            <th class="text-center" rowspan="2">Họ và tên</th>
            <th class="text-center" rowspan="2">Phòng ban</th>
            <th class="text-center" rowspan="2">Vị trí</th>
            <th class="text-center" colspan="{{$end}}">Ngày</th>
            <th class="text-center" colspan="2">Xử phạt</th>
            <th class="text-center" rowspan="2">Công</th>
            <th class="text-center" rowspan="2">Tổng kết</th>
        </tr>
        <tr>
            @for($i = 1; $i<= $end; $i++)
                <th class="text-center">{{$i < 10 ? '0'.$i :$i}}</th>
            @endfor
            <th>Đi muộn</th>
            <th>về sớm</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">IT-2</td>
            <td class="text-center">Nguyễn Minh Tiến</td>
            <td class="text-center">Phòng công nghệ</td>
            <td class="text-center">IT</td>
            @for($i = 1; $i<= $end; $i++)
                <td class="text-center pointer showModal">111</td>
            @endfor
            <td>1</td>
            <td>2</td>
            <th>12</th>
            <td>123</td>

        </tr>
        </tbody>
    </table>
    {{--<div class="pull-left">--}}
    {{--<div class="page-info">--}}
    {{--{{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="pull-right">--}}
    {{--{{ $docs->appends(['search' => request()->search ])->links() }}--}}
    {{--</div>--}}
    {{--<div class="float-right">--}}
        {{--{{$docs->links()}}--}}
    {{--</div>--}}
</div>

