<div class="modal fade draggable" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="full_name">FULL NAME, Ngày 01/02/2023</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mt-3 mb-3">
                    <nav class="nav">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Tổng hợp</a>
                        <a class="nav-link" id="nav-home-don" data-toggle="tab" data-target="#nav-don-tu" type="button" role="tab" aria-controls="nav-don-tu" aria-selected="true">Đơn từ</a>
                        <a class="nav-link" id="nav-home-cong" data-toggle="tab" data-target="#nav-cham-cong" type="button" role="tab" aria-controls="nav-cham-cong" aria-selected="true">Chốt vân tay</a>
                    </nav>
                </div>
                <hr style="margin-top: 1rem;margin-bottom: 1rem;">
                <div class="content tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <p>Công làm việc trong ngày: <span class="cong bold"></span></p>
                        <p>Công ăn trong ngày: <span class="cong-an bold"></span></p>
                        <p>Thông tin nhân sự</p>
                        <p>Mã: <span class="ma-cham-cong bold"></span></p>
                        {{--<p>Vị trí: Media</p>--}}
                        <p>Phòng ban: <span class="department bold"></span></p>
                        {{--<p>Ca làm việc</p>--}}
                        {{--<p>Tên ca: Ca Hành chính</p>--}}
                        {{--<p>Mã ca: HC</p>--}}
                        {{--<p>Thời gian: 08:00- 17:30</p>--}}
                        <p>Chốt vân tay: <span class="chot-van-tay"></span></p>
                        <p>Số giờ: <span class="time bold"></span></p>
                        {{--<p>Số công được tính: 0.9888</p>--}}
                        {{--<p>Công ăn được tính: 0</p>--}}
                    </div>
                    <div class="tab-pane fade" id="nav-don-tu" role="tabpane2" aria-labelledby="nav-home-don">
                        Đơn nghỉ: 08:30 01-03-2023 -> 12:00 01-03-2023
                        <br>
                        Đơn checkin-checkout: 18:00 (Quên chốt vân tay)
                    </div>
                    <div class="tab-pane fade" id="nav-cham-cong" role="tabpane3" aria-labelledby="nav-home-cong">
                        Ngon ngay2
                    </div>
                </div>
                {{--<div class="content">--}}
                    {{--<p>Công làm việc trong ngày: <span></span>0.9888</p>--}}
                    {{--<p>Công ăn trong ngày: 0</p>--}}
                    {{--<p>Thông tin nhân sự</p>--}}
                    {{--<p>Mã: TT.17</p>--}}
                    {{--<p>Vị trí: Media</p>--}}
                    {{--<p>Phòng ban: Công ty CP Tập đoàn Adam Group</p>--}}
                    {{--<p>Ca làm việc</p>--}}
                    {{--<p>Tên ca: Ca Hành chính</p>--}}
                    {{--<p>Mã ca: HC</p>--}}
                    {{--<p>Thời gian: 08:00- 17:30</p>--}}
                    {{--<p>Chốt vân tay: 07:39:41, 01/02/23 - 17:24:36, 01/02/23</p>--}}
                    {{--<p>Số giờ: 7.91 giờ</p>--}}
                    {{--<p>Số công được tính: 0.9888</p>--}}
                    {{--<p>Công ăn được tính: 0</p>--}}
                {{--</div>--}}
            </div>
            {{--<div class="modal-footer">--}}
            {{--<button class="btn btn-primary">Lưu</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
