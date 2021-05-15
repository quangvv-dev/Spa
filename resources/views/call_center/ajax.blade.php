<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Khách hàng</th>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Trạng thái c.gọi</th>
            <th class="text-white text-center">Thời gian</th>
            <th class="text-white text-center">Ghi âm</th>
        </tr>
        </thead>
        <tbody>
        @if (count($docs))
            @foreach($docs as $doc)
                <tr>
                    <td class="text-center">{{@$doc->customer->full_name?:'Số máy lạ'}}</br>
                        <a href="sip:{{@$doc->dest_number}}">{{@$doc->dest_number}}</a>
                    </td>
                    <td class="text-center">{{@$doc->user->caller_number?:'Nhân viên lạ'}}</br>
                        <span>(Số máy lẻ: {{@$doc->caller_number}})</span>
                    </td>
                    <td class="text-center">{{@$doc->call_status=='ANSWERED'?'Trả lời':'Gọi lỡ'}}</td>
                    <td class="text-center">
                        {{date('d-m-Y H:i',strtotime($doc->start_time))}}
                        </br>
                        {{@$doc->expired_text}}
                    </td>
                    <td class="text-center">
                        {{--<i class="fas fa-play-circle fa-2x text-primary"></i>--}}
                        <div class="mediPlayer">
                            <audio class="listen" preload="none" data-size="50" src="{{$doc->recording_url}}"></audio>
                        </div>
                    </td>
                </tr>
            @endforeach



            <tr class="fixed2">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>

            </tr>

            <tr class="fixed">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>

        @else
            <tr>
                <td id="no-data" class="text-center" colspan="11">Không tồn tại dữ liệu</td>
            </tr>
        @endif
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
</div>
<!-- table-responsive -->
