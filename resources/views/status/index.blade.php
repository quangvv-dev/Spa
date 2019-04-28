@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('status.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                {{--                <h3 class="card-title">Full color variations</h3></br>--}}
                <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                {{--                <input class="form-control header-search col-2" placeholder="Search…" tabindex="1" type="search">--}}
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white">ID</th>
                        <th class="text-white text-center">Tên nhóm</th>
                        <th class="text-white text-center">Mã nhóm</th>
                        <th class="text-white text-center">Loại nhóm</th>
                        <th class="text-white text-center">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count(@$docs))
                        @foreach($docs as $k => $s)
                            <tr>
                                <th scope="row">{{$k}}</th>
                                <td class="text-center">{{$s->name}}</td>
                                <td class="text-center">{{$s->code}}</td>
                                <td class="text-center">
                                    @foreach($types_pluck as $k1 => $v)
                                        @if($s->type == $k1)
                                            @php echo $v @endphp
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a class="btn" href="{{ url('status/' . $s->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                    <a class="btn delete" href="javascript:void(0)" data-url="{{ url('status/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                    </tbody>
                    @endforeach
                    @else
                        <tr>
                            <td id="no-data" class="text-center" colspan="7">Không tồn tại dữ liệu</td>
                        </tr>
                    @endif
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
            <!-- table-responsive -->
        </div>
        {{--        @include('status._form')--}}
    </div>
@endsection
