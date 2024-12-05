<style>
    #syncQuickReply .list-group-item {
        padding: 5px 5px !important;
    }

    .checkAllQuick, .checkItemQuick {
        height: 15px !important;
    }
    .stylish-input-group .input-group-addon{
        background: white !important;
    }
    .stylish-input-group .form-control{
        border-right:0;
        box-shadow:0 0 0;
        border-color:#ccc;
    }
    .stylish-input-group button{
        border:0;
        background:transparent;
    }
    .fa-search{
        position: absolute;
        right: 3%;
        top: 31%;
    }

</style>
<div class="modal fade text-left" id="syncQuickReply" tabindex="-1" role="dialog"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-main">
                <h5 class="modal-title" id="myModalLabel"> Đồng bộ trả lời nhanh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(array('url' => url('/marketing/setting-quick-reply/sync/'.$page_id), 'method' => 'post', 'files'=> true, 'id'=>'syncQuick','autocomplete'=>'off')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <img src="{{$fanpage->avatar}}" alt="">
                        <h3 class="ml-1">
                            {{$fanpage->name}}
                        </h3>
                    </div>
                    <div class="col-2">
                        <i aria-label="icon: double-right" class="anticon anticon-double-right"
                           style="font-size: 25px; margin-top: 30px;">
                            <svg viewBox="64 64 896 896" class="" data-icon="double-right" width="1em" height="1em"
                                 fill="currentColor" aria-hidden="true" focusable="false">
                                <path d="M533.2 492.3L277.9 166.1c-3-3.9-7.7-6.1-12.6-6.1H188c-6.7 0-10.4 7.7-6.3 12.9L447.1 512 181.7 851.1A7.98 7.98 0 0 0 188 864h77.3c4.9 0 9.6-2.3 12.6-6.1l255.3-326.1c9.1-11.7 9.1-27.9 0-39.5zm304 0L581.9 166.1c-3-3.9-7.7-6.1-12.6-6.1H492c-6.7 0-10.4 7.7-6.3 12.9L751.1 512 485.7 851.1A7.98 7.98 0 0 0 492 864h77.3c4.9 0 9.6-2.3 12.6-6.1l255.3-326.1c9.1-11.7 9.1-27.9 0-39.5z"></path>
                            </svg>
                        </i>
                    </div>
                    <div class="col">
                        <select name="page_id" id="" class="select2 form-control pageId">
                            <option></option>
                            @forelse($list_fanpage as $item)
                                <option value="{{$item->page_id}}">{{$item->name}}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="row justify-content-center mt-1 mb-1">
                    <div class="">
                        <div class="col-12 form-check d-flex">
                            <label class="form-check-label d-flex align-items-center" for="is_add_push_1">
                                <input class="form-check-input" style="width: 18px" value="add" type="radio" name="is_add_push" id="is_add_push_1" checked>
                                <h5>&nbsp; Thêm vào danh sách hiện có</h5>
                            </label>
                        </div>
                        <div class="col-12 form-check d-flex">
                            <label class="form-check-label d-flex align-items-center" for="is_add_push_2">
                                <input class="form-check-input" style="width: 18px" value="replace" type="radio" name="is_add_push"
                                       id="is_add_push_2">
                                <h5>&nbsp; Thay thế danh sách hiện có</h5>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="ant-popover-inner-content">
                            <ul class="list-group">
                                <li class="list-group-item d-flex align-items-center list-group-item-dark">
                                    <div class="tbl-space" style="width: 38px;">
                                        <input type="checkbox" class="checkAllQuick">
                                    </div>
                                    <div class="tbl-qr-desc" style="display: block; width: 86px;">Ký tự
                                        tắt
                                    </div>
                                    <div class="tbl-space" style="width: 62px;"></div>
                                    <div class="tbl-qr-desc">Tin nhắn</div>
                                    <div id="imaginary_container" style="position: absolute;right: 3px;">
                                        <div class="input-group stylish-input-group">
                                            <span><input type="text" class="form-control searchQuick" placeholder="Search"><i class="fa fa-search"></i></span>

                                        </div>
                                    </div>
                                </li>
                                <span class="forEach">
                                    @forelse($list_quick_reply as $item)
                                        <li class="list-group-item d-flex align-items-center list-group-item-action pointer">
                                            <div style="width: 38px;"><input type="checkbox" name="list_quick[]" value="{{$item->id}}" class="checkItemQuick"></div>
                                            <div style="display: block; width: 86px;">{{$item->shortcut}}</div>
                                            <div class="tbl-space" style="width: 62px;"></div>
                                            <div class="">{!! @str_limit(strip_tags($item->message),120) !!}</div>
                                        </li>
                                    @empty
                                    @endforelse
                                </span>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary submitSync"><i class="fa fa-refresh"> Sync</i></button>

            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

