{{--@php--}}
{{--$hours = floor(($answers->sum('answer_time') / 3600));--}}
{{--$minutes = floor(($answers->sum('answer_time') % 3600)/60);--}}
{{--$sec = round(($answers->sum('answer_time') % 3600)%60);--}}
{{--$time_call =  ($hours > 0 ? $hours . ' giờ ' : '').($minutes > 0 ? $minutes . ' phút ' : '') . ($sec > 0 ? $sec . ' giây' : '');--}}
{{--@endphp--}}
{{--<div class="card-header col-md-12">--}}
{{--<div class="col-md-3 bold">--}}
{{--Tổng cuộc gọi : <span class="text-success">{{@$docs->total()}}</span>--}}
{{--</div>--}}
{{--<div class="col-md-3 bold">--}}
{{--Tổng khách nghe máy: {{$answers->count()}} <span class="text-success">({{$time_call}})</span>--}}
{{--</div>--}}
{{--<div class="col-md-3 bold">--}}
{{--Tổng gọi lỡ : <span class="text-danger">{{$docs->total()-$answers->count()}}</span>--}}
{{--</div>--}}
{{--</div>--}}
<div class="table-responsive tableFixHead" id="parent">
    <table class="table card-table table-vcenter text-nowrap table-primary" id="fixTable">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Trạng thái c.gọi</th>
            <th class="text-white text-center">Thời gian</th>
            <th class="text-white text-center">Ghi âm</th>
        </tr>
        </thead>
        <tbody>
        @if (count($call_center))
            @foreach($call_center as $doc)
                <tr>
                    <td class="text-center">{{@$doc->user->full_name?:'Nhân viên lạ'}}</br>
                        <span class="small-tip">(Số máy lẻ: {{@$doc->caller_number}})</span>
                    </td>
                    <td class="text-center">{!!@$doc->call_status=='ANSWERED'?'<span class="badge badge-success">Nghe máy</span>':
                    '<span class="badge badge-danger">Gọi lỡ</span>' !!}
                    </td>
                    <td class="text-center">
                        {{date('d-m-Y H:i',strtotime($doc->start_time))}}
                        </br>
                        <span class="small-tip">{{@$doc->expired_text}}</span>
                    </td>
                    <td class="text-center">
                        @if($doc->recording_url !='None')
                            <div class="mediPlayer">
                                <audio class="listen" preload="none" data-size="40"
                                       src="{{$doc->recording_url}}"></audio>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach

        @else
            <tr>
                <td id="no-data" class="text-center" colspan="11">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>

</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('.mediPlayer').mediaPlayer();
    });
</script>
<!-- table-responsive -->
