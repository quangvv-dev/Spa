<div class="modal micromodal-slide modal-action-send_email" id="modal-action-email"
     aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true"
             aria-labelledby="modal-action-email-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-action-email-title">
                    Cài đặt
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-action-email-content">
                <form>
                    <div class="form-group">
                        <label for="" class="form-label">Thời gian</label>
                        <div class="custom-controls-stacked">
                            <div>
                                <label class="custom-control custom-radio">
                                    <input class="condition-activator custom-control-input" type="radio"
                                           name="time_type" id="immediately" value="immediately">
                                    <span class="custom-control-label">Ngay lập tức</span>
                                </label>
                            </div>
                            <div>
                                <label class="custom-control custom-radio">
                                    <input checked class="condition-activator custom-control-input" type="radio"
                                           name="time_type" id="delay" value="delay">
                                    <span class="custom-control-label">Chờ</span>
                                </label>
                            </div>
                            <div>
                                <label class="custom-control custom-radio">
                                    <input class="condition-activator custom-control-input" type="radio"
                                           name="time_type" id="exactly" value="exactly">
                                    <span class="custom-control-label">Chính xác</span>
                                </label>
                            </div>
                        </div>
                        <div class="conditional-input form-group delay">
                            <div class="input-group">
                                <input name="delay_value" class="form-control" type="number">
                                <div class="input-group-append">
                                    <select name="delay_unit" id="">
                                        <option value="hours">Giờ</option>
                                        <option value="days">Ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="conditional-input form-group exactly" style="display: none;">
                            <input name="exactly_value" class="form-control datetimepicker" type="text">
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label for="" class="form-label">Từ</label>--}}
                    {{--<input type="text" name="from" class="form-control datetimepicker">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                    {{--<label for="" class="form-label">Tới</label>--}}
                    {{--<input type="text" name="to" class="form-control datetimepicker">--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="" class="form-label">Chủ đề (Email)</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Nội dung</label>
                        <textarea class="form-control autocomplete-textarea textarea-custom" name="content" id="" cols="30" rows="10"></textarea>
                    </div>
                </form>
            </main>
            <footer class="modal__footer">
                <button class="btn btn-primary modal__btn-primary">Cập nhật</button>
                <button class="btn btn-link" data-micromodal-close aria-label="Close this dialog window">
                    Close
                </button>
            </footer>
        </div>
    </div>
</div>
