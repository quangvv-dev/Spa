<div class="modal micromodal-slide modal-action-create_job" id="modal-action-create_job" aria-hidden="true">
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
                        <label for="" class="form-label">Thời gian hết hạn</label>
                        <div class="custom-controls-stacked">
                            {{--<div>--}}
                            {{--<label class="custom-control custom-radio">--}}
                            {{--<input class="condition-activator custom-control-input" type="radio"--}}
                            {{--name="time_type" id="immediately" value="immediately">--}}
                            {{--<span class="custom-control-label">Ngay lập tức</span>--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            <div>
                                <label class="custom-control custom-radio">
                                    <input class="condition-activator custom-control-input" type="radio"
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
                                        {{--<option value="hours">Giờ</option>--}}
                                        <option value="days">Ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="conditional-input form-group exactly">
                            <input name="exactly_value" class="form-control datetimepicker" type="text">
                        </div>
                        {{--check--}}

                        {{--end check--}}
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
