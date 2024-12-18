@extends('layout.app')
<script src="{{url('/go.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/micromodal/dist/micromodal.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.min.js')}}"></script>

<style type="text/css">
    /* CSS for the traditional context menu */
    .menu {
        display: none;
        position: absolute;
        opacity: 0;
        margin: 0;
        padding: 8px 0;
        z-index: 999;
        box-shadow: 0 5px 5px -3px rgba(0, 0, 0, .2), 0 8px 10px 1px rgba(0, 0, 0, .14), 0 3px 14px 2px rgba(0, 0, 0, .12);
        list-style: none;
        background-color: #ffffff;
        border-radius: 4px;
    }

    .menu-item {
        display: block;
        position: relative;
        min-width: 100px;
        margin: 0;
        padding: 6px 16px;
        font: bold 12px sans-serif;
        color: rgba(0, 0, 0, .87);
        cursor: pointer;
    }

    .menu-item::before {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        pointer-events: none;
        content: "";
        width: 100%;
        height: 100%;
        background-color: #000000;
    }

    .menu-item:hover::before {
        opacity: .04;
    }

    .menu .menu {
        top: -8px;
        left: 100%;
    }

    .show-menu, .menu-item:hover > .menu {
        display: block;
        opacity: 1;
    }

    .custom-control-label {
        position: initial !important;
    }

    /**************************\
    Basic Modal Styles
    \**************************/

    .modal {
        font-family: -apple-system, BlinkMacSystemFont, avenir next, avenir, helvetica neue, helvetica, ubuntu, roboto, noto, segoe ui, arial, sans-serif;
    }

    .modal {
        display: none;
    }

    .modal.is-open {
        display: block;
    }

    .modal__overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99;
    }

    .modal__container {
        background-color: #fff;
        padding: 15px;
        width: 500px;
        max-height: 100vh;
        border-radius: 4px;
        overflow-y: auto;
        box-sizing: border-box;
    }

    .modal__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal__title {
        margin-top: 0;
        margin-bottom: 0;
        font-weight: 600;
        font-size: 1.25rem;
        line-height: 1.25;
        color: #00449e;
        box-sizing: border-box;
    }

    .modal__close {
        background: transparent;
        border: 0;
    }

    .modal__header .modal__close:before {
        content: "\2715";
    }

    .modal__content {
        margin-top: 1rem;
        margin-bottom: 1rem;
        line-height: 1.5;
        color: rgba(0, 0, 0, .8);
    }

    .modal__btn {
        font-size: .875rem;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: .5rem;
        padding-bottom: .5rem;
        background-color: #e6e6e6;
        color: rgba(0, 0, 0, .8);
        border-radius: .25rem;
        border-style: none;
        border-width: 0;
        cursor: pointer;
        -webkit-appearance: button;
        text-transform: none;
        overflow: visible;
        line-height: 1.15;
        margin: 0;
        will-change: transform;
        -moz-osx-font-smoothing: grayscale;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        transition: -webkit-transform .25s ease-out;
        transition: transform .25s ease-out;
        transition: transform .25s ease-out, -webkit-transform .25s ease-out;
    }

    .modal__btn:focus, .modal__btn:hover {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
    }

    .modal__btn-primary {
        background-color: #00449e;
        color: #fff;
    }

    /**************************\ Demo Animation Style \**************************/
    @keyframes mmfadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes mmfadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    @keyframes mmslideIn {
        from {
            transform: translateY(15%);
        }
        to {
            transform: translateY(0);
        }
    }

    @keyframes mmslideOut {
        from {
            transform: translateY(0);
        }
        to {
            transform: translateY(-10%);
        }
    }

    .micromodal-slide {
        display: none;
    }

    .micromodal-slide.is-open {
        display: block;
    }

    .micromodal-slide[aria-hidden="false"] .modal__overlay {
        animation: mmfadeIn .3s cubic-bezier(0.0, 0.0, 0.2, 1);
    }

    .micromodal-slide[aria-hidden="false"] .modal__container {
        animation: mmslideIn .3s cubic-bezier(0, 0, .2, 1);
    }

    .micromodal-slide[aria-hidden="true"] .modal__overlay {
        animation: mmfadeOut .3s cubic-bezier(0.0, 0.0, 0.2, 1);
    }

    .micromodal-slide[aria-hidden="true"] .modal__container {
        animation: mmslideOut .3s cubic-bezier(0, 0, .2, 1);
    }

    .micromodal-slide .modal__container, .micromodal-slide .modal__overlay {
        will-change: transform;
    }

    ul.dropdown-menu.textcomplete-dropdown {
        z-index: 99999 !important;
    }
</style>

<script>
    // Prepare data
    // List all
    model = []
    appliedModel = []
    @foreach($elements as $element)
    model.push({
        key: "{{$element->id}}",
        title: "{{$element->title}}",
        color: "{{$element->color}}",
        type: "{{$element->type}}",
        value: "{{$element->value}}"
    })
    @endforeach

        existingDiagram = JSON.parse({!!(!empty($rule->configs) ? $rule->configs : "'{}'")!!});
</script>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">

            <form id="rule_form" action="{{url('rules')}}" method="POST" class="card">
                <div class="card-header">
                    <h3 class="card-title">Rule</h3>
                </div>
                <div class="card-body">
                    @csrf
                    <input type="hidden" name="id" value="{{!empty($rule->id) ? $rule->id : '' }}">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 offset-md-2">
                            <div class="form-group">
                                <label class="form-label">Tiêu đề</label>
                                <input id="title" type="text" name="title" class="form-control" required
                                       value="{{!empty($rule->title) ? $rule->title : '' }}">
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 offset-md-2">
                            <div class="form-group">
                                <div class="form-label">Kích hoạt</div>
                                <label class="custom-switch">
                                    <input type="checkbox"
                                           {{!empty($rule->status) && $rule->status == '1' ? 'checked' : ''}} value=1
                                           name="status" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Tắt/Bật</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 offset-md-2">
                            <div class="form-group">
                                <label class="form-label" for="">Mô hình</label>
                                <div>
                                    <small style="color: orangered">Chuột phải vào vùng dưới để thêm đối tượng</small>
                                </div>
                                <textarea style="display:none" name="configs" cols="30"
                                          rows="10">{{!empty($rule->configs) ? $rule->configs : '{}' }}</textarea>
                                <div style="position:relative">
                                    <div id="myDiagramDiv" style="width:100%; height:600px; border: 1px solid;"></div>
                                    <ul id="contextMenu" class="menu">
                                        <li id="new_actor" class="menu-item">Chọn hành động
                                            <ul class="menu">
                                                @foreach($elements as $element)
                                                    @if($element->type == 'actor')
                                                        <li class="menu-item" onclick="cxcommand(event, 'new')"
                                                            data-id="{{$element->id}}">{{$element->title}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li id="new_event" class="menu-item">Thêm sự kiện
                                            <ul class="menu">
                                                @foreach($elements as $element)
                                                    @if($element->type == 'event')
                                                        <li class="menu-item" onclick="cxcommand(event, 'new')"
                                                            data-id="{{$element->id}}">{{$element->title}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li id="new_action" class="menu-item">Thêm hành động
                                            <ul class="menu">
                                                @foreach($elements as $element)
                                                    @if($element->type == 'action')
                                                        <li class="menu-item" onclick="cxcommand(event, 'new')"
                                                            data-id="{{$element->id}}">{{$element->title}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li id="configs" class="menu-item" onclick="cxcommand(event)">Cài đặt</li>
                                        <li id="delete" class="menu-item" onclick="cxcommand(event)">Xóa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="d-flex">
                        <a href="javascript:void(0)" class="btn btn-link">Hủy bỏ</a>
                        <button id="save" class="btn btn-primary ml-auto">Lưu</button>
                    </div>
                </div>
            </form>
            @include('rules.sms')
            @include('rules.email')
            @include('rules.job')
            <div class="modal micromodal-slide modal-actor-customer" id="modal-actor-customer" aria-hidden="true">
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
                                    <label for="" class="form-label">Nhóm dich vu</label>
                                    <select class="select2-multiple" name="group[]" multiple="multiple">
                                        @foreach($category as $k =>$categories)
                                            <option value="{{$k}}">{{$categories}}</option>
                                        @endforeach()
                                    </select>
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
            <div class="modal micromodal-slide modal-actor-staff" id="modal-actor-staff" aria-hidden="true">
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
                                    <label for="" class="form-label">Trạng thái khách hàng</label>
                                    <select class="select2-multiple" name="group[]" multiple="multiple">
                                        @foreach($status as $k1 => $s)
                                            <option value="{{$k1}}">{{$s}}</option>
                                        @endforeach
                                    </select>
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
            <div class="modal micromodal-slide modal-actor-staff_schedule" id="modal-actor-staff_schedule" aria-hidden="true">
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
                                    <label for="" class="form-label">Trạng thái lịch hẹn</label>
                                    <select class="select2-multiple" name="group[]" multiple="multiple">
                                        @foreach($schedule_status  as $s)
                                            <option value="{{$s['id']}}">{{$s['name']}}</option>
                                        @endforeach
                                    </select>
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
            <div class="modal micromodal-slide modal-actor-staff_customer" id="modal-actor-staff_customer"
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
                                    <label for="" class="form-label">Nhóm dich vu</label>
                                    <select class="select2-multiple" name="group[]" multiple="multiple">
                                        @foreach($category as $k =>$categories)
                                            <option value="{{$k}}">{{$categories}}</option>
                                        @endforeach()
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Trạng thái khách hàng</label>
                                    <select class="select2-multiple" name="group1[]" multiple="multiple">
                                        @foreach($status as $k1 => $s)
                                            <option value="{{$k1}}">{{$s}}</option>
                                        @endforeach
                                    </select>
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
            <div class="modal micromodal-slide modal-actor-info_customer" id="modal-actor-info_customer"
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
                                <div>
                                    <label class="custom-control custom-radio">
                                        <input checked class="condition-activator custom-control-input job-input" type="radio"
                                               name="field_customer" id="field_customer" value="link_fb">
                                        <span class="custom-control-label">Link Facebook</span>
                                    </label>
                                </div>
{{--                                <div>--}}
{{--                                    <label class="custom-control custom-radio">--}}
{{--                                        <input class="condition-activator custom-control-input" type="radio"--}}
{{--                                               name="time_type" id="exactly" value="exactly">--}}
{{--                                        <span class="custom-control-label">Chính xác</span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
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

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/jquery.textcomplete.min.js')}}"></script>
    <script src="{{url('app.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.datetimepicker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                autoUpdateInput:true,
                locale: {
                    format: 'YYYY/MM/DD hh:mm'
                }
            });
        })
    </script>
    <script>
        // $('body').delegate('.autocomplete-textarea', 'keyup', function () {
        //     console.log($(this).val());
        $('.autocomplete-textarea').textcomplete([{
            match: /(^|\s)@(\w*(?:\s*\w*))$/,
            search: function (query, callback) {
                let data = [{
                    name: "Tên khách hàng",
                    value: "%full_name%"
                }, {
                    name: "SĐT khách hàng",
                    value: "%phone%"
                }, {
                    name: "Chi nhánh",
                    value: "%branch%"
                }, {
                    name: "SĐT chi nhánh",
                    value: "%phoneBranch%"
                },{
                    name: "Địa chỉ chi nhánh",
                    value: "%addressBranch%"
                }];
                callback(data);
            },

            template: function (hit) {
                // phan hien thi o dropdown
                let html = `
            <a class="tag-item" href="">
            <span class="label">${hit.name} <img width="30" src='{{asset('/assets/images/brand/logo.png')}}'/></span>
            </a>`;
                return html;
            },

            replace: function (hit) {
                // phan hien thi khi
                return hit.value.trim();
            }
        }]);
        // })

    </script>
@endsection
