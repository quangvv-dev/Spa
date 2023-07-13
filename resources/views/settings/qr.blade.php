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
                                <th class="text-center">Ngân hàng</th>
                                <th class="text-center">Số tài khoản</th>
                                <th class="text-center">Người thụ hưởng</th>
                                <th class="text-center">Chi nhánh</th>
                                <th class="text-center nowrap">
                                    <a id="add_new_bank" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                                </th>
                            </tr>

                            <form>
                            <tbody id="sortable1">
                            @if(count($banks))
                                @foreach($banks as $k =>$item)
                                    <tr data-id="{{$item->id}}">

                                        <td class="text-center">
                                            {{$k+1}}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::select('bank_code',$banks_code,@$item->bank_code ,array('class' => 'form-control select2','required' => true)) !!}
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="account_number txt-dotted form-control" value="{{$item->account_number}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="account_name txt-dotted form-control" value="{{$item->account_name}}">
                                        </td>
                                        <td class="text-center">
                                            <select class="form-control branch_id">
                                                @forelse($branchs as $b)
                                                    <option {{$b->id == $item->branch_id?'selected' : ''}} value="{{$b->id}}">{{$b->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn save-bank" href="javascript:void(0)"
                                               data-id="{{$item->id}}">
                                                <i class="fa fa-save"></i>
                                            </a>
                                            <a class="btn delete" href="javascript:void(0)"
                                               data-url="{{'bank/'.$item->id}}">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            </form>
                        </table>
                    </div>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
</div>
