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
                                <th class="text-center" style="width: 150px">SĐT liên hệ</th>
                                <th class="text-center">Địa chỉ</th>
                                <th class="text-center">Khu vực</th>
                                <th class="text-center" style="width: 300px">Hiển thị (Bill)</th>
                                <th class="text-center nowrap">
                                    <a id="add_new_status" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="sortable1">
                            @if(count($branchs))
                                @foreach($branchs as $k =>$item)
                                    <tr data-id="{{$item->id}}">

                                        <td class="text-center">
                                            {{$k+1}}
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="name txt-dotted form-control" value="{{$item->name}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="phone txt-dotted form-control" value="{{$item->phone}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="address txt-dotted form-control" value="{{$item->address}}">
                                        </td>
                                        <td class="text-center">
                                            {!! Form::select('location_id', $location, $item->location_id, array('class' => 'form-control location select-gear', 'placeholder' => 'Chọn cụm')) !!}
                                        </td>
                                        <td class="text-center row">
                                            <input  type="text" class="lat txt-dotted form-control col-6" value="{{$item->lat}}">
{{--                                            <input style="max-width: 150px" type="text" class="long txt-dotted form-control col-6" value="{{$item->long}}">--}}
                                        </td>
                                        <td class="text-center">
                                            <a class="btn save-status" href="javascript:void(0)"
                                               data-id="{{$item->id}}">
                                                <i class="fa fa-save"></i>
                                            </a>
                                            <a class="btn delete" href="javascript:void(0)"
                                               data-url="{{'branch/'.$item->id}}">
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
