<div class="modal fade modal-custom text-left" id="add_new_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h3 class="modal-title-custom linear-text fs-24" id="myModalLabel35"> Thêm mới thông tin đội, nhóm</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('teams.store')}}" method="post" id="team-my-form">
                @csrf
                <div class="modal-body">
                    <div class="row mt-1">
                        <div class="col-sm-2">
                            <label class="required">Kiểu nhóm</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="department_id" id="department_id" class="select2 form-control square">
                                <option value="{{\App\Constants\DepartmentConstant::TELESALES}}">Nhóm sale</option>
                                <option value="{{\App\Constants\DepartmentConstant::CSKH}}">Nhóm CSKH</option>
                                <option value="{{\App\Constants\DepartmentConstant::MARKETING}}">Nhóm Marketing</option>
                                <option value="{{\App\Constants\DepartmentConstant::CARE_PAGE}}">Nhóm Carepage</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-2">
                            <label class="required">Mã nhóm</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="code" id="code" class="form-control square">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-2">
                            <label class="required">Tên nhóm</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control square">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-2">
                            <label class="required">Trưởng nhóm</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="leader_id" id="leader_id" class="select2 form-control square"
                                    data-placeholder="--Chọn trưởng nhóm">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-2">
                            <label class="required">Thành viên</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="user_id[]" id="user_id" class="select2 form-control square" multiple>
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>
