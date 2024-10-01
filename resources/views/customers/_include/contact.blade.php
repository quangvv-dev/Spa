<style>
    th.text-white.text-center {
        text-transform: unset;
    }
</style>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-bordered table-primary">
        <thead class="text-white">
        <tr>
            <th class="text-white text-center"></th>
            <th class="text-white text-center">Mã HĐ</th>
            <th class="text-white text-center">Dịch vụ</th>
            <th class="text-white text-center">Ngày bắt đầu điều trị</th>
            <th class="text-white text-center">Hiệu lực</th>
            <th class="text-white text-center">Số tiền</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @forelse($contacts as $item)
            <tr>
                <td><a class="btn btn-info" href="{{url('contact-pdf/'.$item->id)}}">
                        <i style="color: white !important;" class="fa fa-print"></i>
                    </a>
                </td>
                <td>{{$item->code}}</td>
                <td>{{$item->service}}</td>
                <td>{{date('d-m-Y',strtotime($item->date))}}</td>
                <td>{{$item->warranty_number?:0}} tháng</td>
                <td>{{number_format($item->price)}}</td>
            </tr>
            @empty
        @endforelse
        </tbody>
    </table>
</div>
