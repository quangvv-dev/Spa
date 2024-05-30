<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Đơn tư vấn</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Còn nợ</th>
            <th class="text-white text-center">Thực thu</th>

        </tr>

        </thead>
        <tbody>
        @forelse($data as $key => $item)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td class="text-center">
                    {{$item['full_name']}}
                    <br>
{{--                    <span class="small-tip">12341234</span>--}}

                </td>
                <td class="text-center">{{number_format($item['orders'])}}</td>
                <td class="text-center">{{number_format($item['all_total'])}}</td>
                <td class="text-center">{{number_format($item['gross_revenue'])}}</td>
                <td class="text-center">{{number_format($item['the_rest'])}}</td>
                <td class="text-center">{{number_format($item['price'])}}</td>
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
</div>

