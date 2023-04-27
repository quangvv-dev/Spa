<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" rowspan="2">TT</th>
            {{--<th class="text-center" rowspan="2">CN</th>--}}
            <th class="text-center" rowspan="2" style="left: 0;z-index: 100">Họ và tên</th>
            <th class="text-center" rowspan="2" style="left: 221px;z-index: 101">Phòng ban</th>
            <th class="text-center" rowspan="2" style="left: 342px;z-index: 102">Vị trí</th>
            <th class="text-center" colspan="{{$end}}">Ngày</th>
            <th class="text-center" colspan="2">Xử phạt</th>
            <th class="text-center" rowspan="2">Tổng công</th>
        </tr>
        <tr>
            @for($i = 1; $i<= $end; $i++)
                <th class="text-center bottom-th">{{$i < 10 ? '0'.$i :$i}}</th>
            @endfor
            <th class="text-center bottom-th">Đi muộn</th>
            <th class="text-center bottom-th">về sớm</th>
        </tr>

        </thead>
        <tbody>
        @forelse($docs as $key => $item)
            <tr data-id="{{$item->id}}">
                <td class="text-center">{{$key+1}}</td>
                <td class="text-center" style="left: 0;z-index: 100;position: sticky">{{$item->full_name}}</td>
                <td class="text-center" style="left: 0;z-index: 100;position: sticky">{{@$item->department->name}}</td>
                <td class="text-center" style="left: 0;z-index: 100;position: sticky"></td>
                @for($i = 1; $i<= $end; $i++)
                    <td class="text-center pointer showModal" data-date="{{$i}}">{{$item->approval[$i]}}</td>
                @endfor
                <td>{{array_sum($item->late) >0 ? array_sum($item->late) : 0}}</td>
                <td>{{array_sum($item->early) >0 ? array_sum($item->early) : 0}}</td>
                <th class="bold">{{array_sum($item->approval)}}</th>
                {{--<td>123</td>--}}
            </tr>
        @empty
            <td></td>
        @endforelse
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

