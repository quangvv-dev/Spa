@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('users.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white">ID</th>
                        <th class="text-white text-center">Họ tên</th>
                        <th class="text-white text-center">Số điện thoại</th>
                        <th class="text-white text-center">Ngày sinh</th>
                        <th class="text-white text-center">Quyền</th>
                        <th class="text-white text-center">Giới tính</th>
                        <th class="text-white text-center">MKT ID</th>
                        <th class="text-white text-center">Trạng thái</th>
                        <th class="text-white text-center">Trạng thái đăng nhập</th>
                        <th class="text-white text-center">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($users))
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td class="text-center">{{ $user->full_name }}</td>
                            <td class="text-center">{{ $user->phone }}</td>
                            <td class="text-center">{{ $user->birthday }}</td>
                            <td class="text-center">{{ $user->role_text }}</td>
                            <td class="text-center">{{ $user->gender_text  }}</td>
                            <td class="text-center">{{ $user->marketing ? $user->marketing->full_name: '' }}</td>
                            <td class="text-center">{{ @$user->status->name }}</td>
                            <td class="text-center">{{ $user->active_text}}</td>
                            <td class="text-center">
                                @if (Auth::user()->role == \App\Constants\UserConstant::ADMIN)
                                    <a class="btn" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn delete" href="javascript:void(0)" data-url="{{ route('users.destroy', $user->id) }}"><i class="fas fa-trash-alt"></i></a>
                                @endif
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
                        {{ 'Tổng số ' . $users->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}
                    </div>
                </div>
                <div class="pull-right">
                    {{ $users->appends(['search' => request()->search ])->links() }}
                </div>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
