<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
{{--            <th class="text-white"></th>--}}
            <th class="text-white" style="width: 10px">STT</th>
            <th class="text-white text-center">Khách hàng</th>
            <th class="text-white text-center">SĐT</th>
            <th class="text-white text-center">Lịch hẹn</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Còn nợ</th>
            @if(\Illuminate\Support\Facades\Auth::user()->department_id != \App\Constants\DepartmentConstant::ADMIN)
                <th style="min-width: 121px" class="text-white text-center">Mô tả</th>
            @else
                <th class="text-white text-center">Sale</th>
                <th style="min-width: 121px" class="text-white text-center">Mô tả</th>
            @endif
            <th class="text-white text-center">Trạng thái</th>
            <th class="text-white text-center">Chi nhánh</th>
        </tr>
        </thead>
        <tbody>
        @if (count($customers))
            @foreach($customers as $k => $c)
                <tr>
                    <th class="text-center" scope="row" style="background: {{\App\Models\CustomerCampaign::statusColor[$c->status]}};color: white">
                        {{ $k +1 }}
                    </th>
                    <td class="text-center">
                        <a href="{{route('customers.show',$c->customer_id)}}">{{@$c->customer->full_name}}</a>
                        <a style="color: orange" class="view_modal" data-customer-id="{{ $c->customer_id }}">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        <a style="color: #25a11a"  data-toggle="modal" data-id="{{ $c->id }}" class="open-modal-schedule"
                           data-target="#createScheduleModal"> <i class="far fa-calendar"></i></a>
                    </td>
                    <td class="text-center"><a href="callto:{{@$c->customer->phone }}">{{ str_limit(@$c->customer->phone,7,'xxx') }}</a>
                    </td>
                    <td class="text-center">{{@$c->schedules->count()}}</td>
                    <td class="text-center">{{@$c->orders->count()}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('all_total'))}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('gross_revenue'))}}</td>
                    <td class="text-center">{{@number_format($c->orders->sum('all_total') - $c->orders->sum('gross_revenue'))}}</td>
                    @if(\Illuminate\Support\Facades\Auth::user()->department_id != \App\Constants\DepartmentConstant::ADMIN)
                        <td style="position: relative;max-width: 146px">
                            <textarea data-id="{{$c->id}}" class="description-cus">{{ @$c->message }}</textarea>
                        </td>
                    @else
                        <td class="text-center">{{@$c->sale->full_name}}</td>
                        <td style="position: relative;max-width: 146px">
                            <textarea data-id="{{$c->id}}" class="description-cus">{{ @$c->message }}</textarea>
                        </td>
                    @endif
                    <td class="text-center">
                        {!! Form::select('the_rest', \App\Models\CustomerCampaign::statusLabel, @$c->status, array('class' => 'form-control status',
                            'data-id'=> $c->id,'placeholder'=>'Tất cả trạng thái')) !!}
                    </td>
                    <td class="text-center">{{@$c->customer->branch->name}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="11">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $customers->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $customers->links() }}
    </div>
</div>
<!-- table-responsive -->
