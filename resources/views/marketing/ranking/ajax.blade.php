<div class="card-body table-responsive">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 form-group">
            <div class="square">
                <div class="content1">
                    <div class="bxh bxh-container" style="border:1px solid transparent;">
                        <div
                            style="transform: rotate(-12.5deg); height: 8px; width: 100%; background-color: #ecedef; position: absolute; top: 13.5%;"></div>
                        @if(count($marketing))
                            @php $key = 0;$check=0; @endphp
                            @foreach($marketing  as $item)
                                @php $key ++ ;@endphp
                                @if ($key >10)
                                    @break
                                @endif
                                <div
                                    class="item-rank {{\Illuminate\Support\Facades\Auth::user()->id==$item['id']?'my-rank':''}} {{$key==1?'item-rank1':'item-rank'.($key)}}">
                                    <div class="king-sale">
                                        <img src="{{asset('images/bxh2.png')}}">
                                    </div>
                                    <div
                                        class="avatar-container {{$key == 1?'blink1':'blink'.($key)}}">
                                        <img class="avatar-img"
                                             src="{{$item['avatar'] ? $item['avatar'] : asset('assets/images/brand/logo.png')}}">
                                    </div>
                                    <div class="item-info">
                                        <div
                                            class="item-stt">{{$key==1?'#1':(int)$key}}</div>
                                        <div class="item-tennv">{{@$item['full_name']}}</div>
                                        <div class="item-ds">
                                            {{number_format((int)$item['gross_revenue'])}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if((count($my_key) && $my_key[0]>9))
                                <div class="item-rank my-rank item-rank11">
                                    <div class="king-sale">
                                        <img src="{{asset('images/bxh2.png')}}">
                                    </div>
                                    <div
                                        class="avatar-container {{'blink'.($my_key[0]+1)}}">
                                        <img class="avatar-img"
                                             src="{{$response[$my_key[0]]['avatar'] ? $response[$my_key[0]]['avatar'] : asset('assets/images/brand/logo.png')}}">

                                    </div>
                                    <div class="item-info">
                                        <div class="item-stt">{{$my_key[0]}}</div>
                                        <div class="item-tennv">{{@$response[$my_key[0]]['full_name']}}</div>
                                        <div class="item-ds">
                                            {{number_format((int)@$response[$my_key[0]]['gross_revenue'])}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
