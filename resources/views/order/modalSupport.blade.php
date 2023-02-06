<div class="modal fade" id="userSupport" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chọn tư vấn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <select class="image-picker selectSupport">
                    <optgroup label="Chọn tư vấn" class="user-list">
                        <option value=""></option>
                        @forelse($customer_support as $item)
                            <option {{isset($order) && $order->support_id == $item->id ? 'selected' : ''}} data-img-src="{{$item->avatar?:setting('logo_website')}}" value="{{@$item->id}}">{{@$item->full_name}}</option>
                        @empty
                        @endforelse
                        {{--<option data-img-src="https://placeimg.com/220/200/arch" value="2">Cute Kitten 2</option>--}}
                        {{--<option data-img-src="https://placeimg.com/220/200/nature" value="3">Cute Kitten 3</option>--}}
                        {{--<option data-img-src="https://placeimg.com/220/200/people" value="4">Cute Kitten 4</option>--}}
                    </optgroup>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary saveSupport" data-dismiss="modal">Lưu</button>
            </div>
        </div>
    </div>
</div>