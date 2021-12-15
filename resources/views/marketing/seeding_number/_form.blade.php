<form action="{{route('marketing.seeding-number.store')}}" id="myFormId" method="post">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="" class="control-label required">Số seeding</label>
                <textarea class="form-control square seeding_number" rows="3" name="seeding_number"></textarea>
                <small for="" class="control-label">
                    * Có thể nhập nhiều số seeding cách nhau bằng dấu ";" hoặc xuống dòng </br>
                    ** Nếu số seeding đã tồn tại hệ thống sẽ bỏ qua
                </small>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary btnAdd"><i class="fa fa-plus"> Thêm mới</i></button>
    </div>
</form>
