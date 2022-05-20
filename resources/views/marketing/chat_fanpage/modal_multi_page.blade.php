<!-- Modal -->
<div class="modal fade" id="modalMultiPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chế độ gộp trang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs listTab" id="nav-tab" role="tablist">
                        @forelse($group_multi as $key=> $item)
                            <a class="nav-item nav-link group-name {{$key==0 ? 'active': ''}}" data-name="{{$item->name}}" data-id="{{$item->id}}" data-toggle="tab" role="tab" aria-selected="true">
                                {{$item->name}}
                                <span class="delete-group" style="display: none" data-id="{{$item->id}}">x</span>
                            </a>
                        @empty
                        @endforelse

                    </div>
                    <span style="font-size: 34px;cursor: pointer;font-weight: 400;position: absolute;right: 15px;top: 15px;"
                          class="addTab">+</span>
                </nav>
                <div class="row mt-1 mb-1">
                    <div class="col-6">
                        <div class="d-flex">
                            Các trang sẽ gộp: <span class="multipage-selectedCount"></span>;
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control quickSearchPage" placeholder="Nhập tên hoặc ID trang">
                    </div>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="row forEach">
                            @forelse($fanpages as $item)
                                <div class="col-4">
                                    <div class="card border-info box-shadow-0 bg-transparent">
                                        <div class="card-content">
                                            <img src="{{$item->avatar?:'/images/avatar.jpg'}}" alt="element 04"
                                                 width="90"
                                                 class="float-left img-fluid">
                                            <div class="card-body pt-3 f-page">
                                                <p class="pointer">{!! @str_limit(strip_tags($item->name),120) !!}
                                                    {{strlen($item->name) >120 ? '...' : ''}}</p>
                                                <p class="small-tip">{{@$item->user->full_name}} ({{$item->page_id}})</p>
                                                {{--<span ></span>--}}
                                            </div>
                                            <input type="checkbox" class="checkbox checkPage {{$item->page_id}}"
                                                   value="{{$item->page_id}}" data-token="{{$item->access_token}}"
                                                   data-name="{{$item->name}}">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Không có kết quả nào</p>
                            @endforelse
                        </div>
                    </div>
                    {{--<div class="tab-pane fade" id="nav-profile" role="tabpanel">2</div>--}}
                    {{--<div class="tab-pane fade" id="nav-contact" role="tabpanel">3</div>--}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitMultiPage">Vào chế độ gộp trang</button>
            </div>
        </div>
    </div>
</div>