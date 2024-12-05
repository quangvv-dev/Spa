<div style="width: 100%; overflow: auto;margin-top: 20px;height: 900px;" class="tableFixHead">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">NHÂN VIÊN</th>
            @forelse($status as $s)
                <th class="text-center">{{$s->name}}</th>
            @empty
            @endforelse
        </tr>
        </thead>

        <tbody>
        @forelse($newData as $key => $new)
            <tr>
                <td class="text-center">{{$key +1}}</td>
                <td class="text-center">{{$new['full_name']}}</td>
                @forelse($status as $s)
                    <td class="text-center">{{$new['status_'.$s->id]}}</td>
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse
        <tr>
            <td class="text-center bold" colspan="2">TỔNG</td>
            @forelse($status as $s)
                <td class="text-center bold">{{$newData->sum('status_'.$s->id)}}</td>
            @empty
            @endforelse
        </tr>

        </tbody>
    </table>
</div>
