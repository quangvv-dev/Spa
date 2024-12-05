<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" style="width: 30px;">STT</th>
            <th class="text-center nowrap">Loại nhóm</th>
            <th class="text-center">Mã</th>
            <th class="text-center">Tên</th>
            <th class="text-center nowrap">Trưởng nhóm</th>
            <th class="text-center nowrap">Thành viên</th>
            <th class="text-center nowrap">Cập nhật</th>
            <th class="text-center nowrap">
                <a id="add_new" data-toggle="modal" data-target="#add_new_form"><i class="fa fa-plus"></i> Thêm
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @if(count($data))
            @foreach($data as $key=>$item)
                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td class="text-center">
                        {{$item->department_id==\App\Constants\DepartmentConstant::TELESALES?'Sale'
                        :($item->department_id==\App\Constants\DepartmentConstant::MARKETING?'Marketing'
                        :($item->department_id==\App\Constants\DepartmentConstant::CSKH?'CSKH':'Carepage')
                        )}}
                    </td>
                    <td class="text-center">{{@$item->code}}</td>
                    <td class="text-center">{{@$item->name}}</td>
                    <td class="text-center">{{@$item->user->full_name}}</td>
                    <td class="text-center">{{@$item->getNameUser()}}</td>
                    <td class="text-center">{{@$item->created_at}}</td>
                    <td class="text-center">
                        <a class="action-control edit" href="javascript:void(0)"
                           data-team="{{$item}}"
                           data-member="{{json_encode($item->arrayIdTeamMember())}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="action-control delete" href="javascript:void(0)"
                           data-url="{{route('teams.destroy',$item->id)}}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9"></td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $data->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $data->appends(['search' => @$input['search'],'branch_id' => @$input['branch_id'],'department_id' => @$input['department_id'] ])->links() }}
    </div>
</div>
<!-- table-responsive -->
