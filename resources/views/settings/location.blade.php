<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                {{--<div class="card-header">--}}
                    {{--<h3 class="card-title">QL chi nhánh</h3></br>--}}
                {{--</div>--}}
                <div id="registration-form">
                    <div class="table card-table table-vcenter text-nowrap table-primary"
                         style="width: 100%; overflow-x: auto;">
                        <table class="table-sortable1 table table-custom">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 30px;">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center nowrap">
                                    <a id="add_new_location" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="sortable1">
                            @if(count($locations))
                                @foreach($locations as $k =>$item)
                                    <tr data-id="{{$item->id}}">

                                        <td class="text-center">
                                            {{$k+1}}
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="name txt-dotted form-control" value="{{$item->name}}">
                                        </td>
                                        <td class="text-center">
                                            <a class="btn save-location" href="javascript:void(0)"
                                               data-id="{{$item->id}}">
                                                <i class="fa fa-save"></i>
                                            </a>
                                            <a class="btn delete" href="javascript:void(0)"
                                               data-url="{{'location/'.$item->id}}">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
</div>
