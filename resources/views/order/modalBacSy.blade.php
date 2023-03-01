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
                <div class="row mb-2">
                    <div class="col-12">
                        {{--<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">--}}
                            {{--<li class="nav-item" role="presentation">--}}
                                {{--<button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Bác sĩ</button>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item" role="presentation">--}}
                                {{--<button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Y tá chính</button>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item" role="presentation">--}}
                                {{--<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Y tá phụ</button>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item" role="presentation">--}}
                                {{--<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-tu-van" type="button" role="tab" aria-controls="pills-tu-van" aria-selected="false">Tư vấn</button>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Bác sĩ</button>
                                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Y tá chính</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Y tá phụ</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-tu-van" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Tư vấn</button>
                            </div>
                        </nav>

                    </div>

                </div>


                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...2</div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...3</div>
                    <div class="tab-pane fade" id="nav-tu-van" role="tabpanel" aria-labelledby="nav-tu-van-tab">...4</div>
                </div>

            </div>
            {{--<div class="modal-footer">--}}
            {{--<button class="btn btn-primary">Lưu</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>