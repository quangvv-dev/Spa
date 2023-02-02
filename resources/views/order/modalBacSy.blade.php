<div class="modal fade" id="userBacSy" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chọn Bác Sỹ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <select class="image-picker selectDoctor">
                    <optgroup label="PlaceIMG" class="user-list">
                        <option value=""></option>
                        @forelse($spaTherapissts as $item)
                            <option {{isset($order) && $order->spa_therapisst_id == $item->id ? 'selected' : ''}} data-img-src="{{$item->avatar}}" value="{{$item->id}}">{{$item->full_name}}</option>
                        @empty
                        @endforelse
                    </optgroup>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>