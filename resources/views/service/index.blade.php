@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('services.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            {!! Form::open(array('url' => route('category.index'), 'method' => 'get','class'=>'card-header')) !!}
            <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                   type="search">
            {{--                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>--}}
            {{--                    </button>--}}
            {{ Form::close() }}
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white">STT</th>
                        <th class="text-white">Ảnh</th>
                        <th class="text-white text-center">Tên dịch vụ</th>
                        <th class="text-white text-center">Mã dịch vụ</th>
                        <th class="text-white text-center">Mô tả ngắn</th>
                        <th class="text-white text-center">Nhà cung cấp</th>
                        <th class="text-white text-center">Thuộc danh mục</th>
                        <th class="text-white text-center">Trạng thái</th>
                        <th class="text-white text-center">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(@count($docs))
                        @foreach($docs as $k => $s)
                            <tr>
                                <th scope="row">{{$k+1}}</th>
                                <th scope="row">
                                    <img src="{{App\Helpers\Functions::getImageModels($s,'services','images')}}" class="rounded-circle" height="60" width="60" />
                                </th>
                                <td class="text-center">{{$s->name}}</td>
                                <td class="text-center">{{$s->code}}</td>
                                <td class="text-center">{{$s->description}}</td>
                                <td class="text-center">{{$s->trademark}}</td>
                                <td class="text-center">{{$s->category->name}}</td>
                                <td class="text-center">{{$s->active_text}}</td>
                                <td class="text-center">
                                    <a class="btn" href="{{ url('services/' . $s->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                    <a class="btn delete" href="javascript:void(0)"
                                       data-url="{{ url('services/' . $s->id) }}"><i class="fas fa-trash-alt"></i></a>
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
