<div class="modal fade" id="userBacSy" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chọn Bác Sỹ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{--<select class="image-picker selectDoctor">--}}
                    {{--<optgroup label="Chọn bác sỹ" class="user-list">--}}
                        {{--<option value=""></option>--}}
                        {{--@forelse($spaTherapissts as $item)--}}
                            {{--<option {{isset($order) && $order->spa_therapisst_id == $item->id ? 'selected' : ''}} data-img-src="{{$item->avatar}}"--}}
                                    {{--value="{{$item->id}}">{{$item->full_name}}</option>--}}
                        {{--@empty--}}
                        {{--@endforelse--}}
                    {{--</optgroup>--}}
                {{--</select>--}}

                <div class="row mb-2">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <input type="text" class="form-control input-custom quickSearchPage quickSearchPageDoctor" placeholder="Nhập tên">
                    </div>
                </div>

                <ul class="thumbnails image_picker_selector">
                    <li class="group">
                        <ul>
                            @forelse($spaTherapissts as $item)
                                <li class="selectDoctor" data-id="{{$item->id}}" data-name="{{$item->full_name}}">
                                    <div class="thumbnail {{isset($order) && $order->spa_therapisst_id == $item->id ? 'selected' : ''}}">
                                        <img class="image_picker_image" src="{{$item->avatar?:setting('logo_website')}}">
                                        <p>{{$item->full_name}}</p>
                                    </div>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </li>
                </ul>
            </div>
            {{--<div class="modal-footer">--}}
            {{--<button class="btn btn-primary">Lưu</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>