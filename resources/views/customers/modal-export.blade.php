<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
<div class="modal fade" id="myModalExport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 25%">
            <div class="modal-header">
                <h4>Tải Data khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customer.export'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
                <div class="row">
                    @if(empty($checkRole))
                        <div class="col-md-12 col-xs-12">
                            <i style="color: red">Chi nhánh</i><br>
                            <select name="branch_id" class="form-control branch_id select2">
                                <option value="">Tất cả chi nhánh</option>
                                @foreach($branchs as $k=> $item)
                                    <option value="{{$k}}">{{ $item}}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="branch_id" value="{{$checkRole}}">
                    @endif

                    <div class="col-md-12">
                        <i style="color: red">Chọn trạng thái KH</i><br>
                        {!! Form::select('status',$status, null, array('class' => 'form-control select2','placeholder'=>'Tất cả')) !!}
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <i style="color: red">Nhóm khách hàng</i><br>
                        <select name="group" class="form-control select2">
                            <option value="">Nhóm dịch vụ</option>
                            @foreach($categories as $item)
                                <option value="{{$item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="col-md-12">
                            <i style="color: red">Từ ngày - tới ngày</i><br>
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input id="reportrange" type="text" class="form-control square">
                        </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Tải xuống</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/daterangepicker.min.js')}}"></script>
<script src="{{asset('js/dateranger-config.js')}}"></script>
