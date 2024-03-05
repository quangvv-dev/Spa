<div class="table-responsive">
    <div class="card-header">
        <div class="col-md-3 bold">
            Tổng lỗi : <span class="text-info">{{$monitoring->total()}}</span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự mắc lỗi: <span class="text-success"></span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự nghỉ việc (Khóa TK) : <span class="text-danger"></span>
        </div>
        <div class="col-md-3 bold">
            Nhân sự tạm nghỉ : <span class="text-warning">0</span>
        </div>
    </div>
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">Thời gian mắc lỗi</th>
            <th class="text-white text-center">Giám sát</th>
            <th class="text-white text-center">Vị trí</th>
            <th class="text-white text-center">Nhân viên vi phạm</th>
            <th class="text-white text-center">Phân loại quy trình</th>
            <th class="text-white text-center">Khối</th>
            <th class="text-white text-center">Lỗi</th>
            <th class="text-white text-center">Note</th>
            <th class="text-white text-center">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @if (count($monitoring))
            @foreach($monitoring as $m)
                <tr>
                    <th scope="row">{{ $m->date_check.' '.$m->time}}</th>
                    <td class="text-center">{{ !empty($m->owner)?$m->owner->full_name:'X' }}</td>
                    <td class="text-center">{{!empty($m->position)?$m->position->name:'X'}}</td>
                    <td class="text-center">{{ !empty($m->user)?$m->user->full_name:'X' }}</td>
                    <td class="text-center">{{ !empty($m->classify)?$m->classify->name:'X' }}</td>
                    <td class="text-center">{{ !empty($m->block)?$m->block->name:'X' }}</td>
                    <td class="text-center">{{ !empty($m->error)?$m->error->name:'X' }}</td>
                    <td class="text-center">{{ $m->note??''}}</td>
                    <td class="text-center">
                        <label class="switch">
                            <input data-id="{{$m->id}}" name="checkbox" class="check"
                                   type="checkbox" {{$m->status==\App\Constants\StatusCode::ON?'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                        <a title="sửa tài khoản" class="btn" href="{{ route('errors.monitoring.edit', $m->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <a title="Xóa tài khoản" class="btn delete" href="javascript:void(0)"
                           data-url="{{ route('errors.monitoring.destroy', $m->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $monitoring->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $monitoring->links() }}
    </div>
</div>
<!-- table-responsive -->
