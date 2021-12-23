<div class="table-responsive" id="registration-form">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Danh mục</th>
            <th class="text-white text-center">Lý do</th>
            <th class="text-center nowrap">
                <a id="add_new_cate" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
            </th>
        </tr>
        </thead>
        <tbody>
        <form action="">
        @if(@count($docs))
            @foreach($docs as $k => $s)
                <tr>
                    <td scope="row">{{$k+1}}</td>
                    <td>
                        {!! Form::select('category_id',$categories,@$s->category_id, array('class' => 'form-control select2 category_id','placeholder'=>'Chọn danh mục')) !!}
                    </td>
                    <td class="text-center">
                        <input type="text" class="name txt-dotted" value="{{$s->name}}">
                    </td>
                    <td class="text-center">
                        <a class="btn save-cate" data-id="{{$s->id}}"><i
                                    class="fas fa-save"></i></a>
                        <a class="btn delete" href="javascript:void(0)"
                           data-url="{{ url('ly-do-thu-chi/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
                    </td>


                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </form>
        </tbody>

    </table>
    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
        </div>
    </div>
    <div class="pull-right">
        {{ $docs->appends(['search' => request()->search ])->links() }}
    </div>
</div>

