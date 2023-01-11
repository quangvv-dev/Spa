<div class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">Nguồn</th>
            @forelse($job as $item)
                <th class="text-center">{{$item->name}}</th>
            @empty
            @endforelse
        </tr>

        </thead>

        <tbody>
        @forelse($source as $item)
            <tr>
                <td>{{$item->name}}</td>
                @forelse($item->job as $item1)
                    <td class="text-center">{{number_format($item1->price)}}</td>
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>