<div class="modal fade" id="userSupport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chọn tư vấn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <input type="text" class="form-control input-custom quickSearchPage quickSearchPageSupport" placeholder="Nhập tên">
                    </div>
                </div>

                <ul class="thumbnails image_picker_selector">
                    <li class="group">
                        <ul>
                            @forelse($customer_support as $item)
                                <li class="selectSupport" data-id="{{$item->id}}" data-name="{{$item->full_name}}">
                                    <div class="thumbnail {{isset($order) && $order->support_id == $item->id ? 'selected' : ''}}">
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
                {{--<button class="btn btn-primary saveSupport" data-dismiss="modal">Lưu</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>