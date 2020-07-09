<div class="table-responsive">
    <table class="table card-table table-center text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Hoa hồng</th>
            <th class="text-white text-center">Tổng doanh số đơn hàng</th>
            <th class="text-white text-center">Tổng doanh thu đơn hàng</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($data))
            @foreach($data as $k => $s)
                <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td class="text-center">{{@$s->users->full_name}}</td>
                    <td class="text-center">{{@number_format($s->total)}}</td>
                    <td class="text-center">{{@number_format($s->all_total)}}</td>
                    <td class="text-center">{{@number_format($s->gross_revenue)}}</td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
    </table>
</div>
