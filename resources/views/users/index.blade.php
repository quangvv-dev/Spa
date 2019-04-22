@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Full color variations</h3></br>
{{--                <input class="form-control header-search col-2" placeholder="Search…" tabindex="1" type="search">--}}
{{--                <input class="form-control header-search col-2" placeholder="Search…" tabindex="1" type="search">--}}
            </div>
            <div class="card-header">
{{--                <h3 class="card-title">Full color variations</h3></br>--}}
                <input class="form-control header-search col-2" placeholder="Search…" tabindex="1" type="search">
{{--                <input class="form-control header-search col-2" placeholder="Search…" tabindex="1" type="search">--}}
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap table-primary">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-white">ID</th>
                        <th class="text-white text-center">Họ tên</th>
                        <th class="text-white text-center">Số điện thoại</th>
                        <th class="text-white text-center">Email</th>
                        <th class="text-white text-center">Ngày sinh</th>
                        <th class="text-white text-center">Role</th>
                        <th class="text-white text-center">Giới tính</th>
                        <th class="text-white text-center">MKT ID</th>
                        <th class="text-white text-center">Trạng thái</th>
                        <th class="text-white text-center">Trạng thái đăng nhập</th>
                        <th class="text-white text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($users as $user)
                        <th scope="row">{{ $user->id }}</th>
                        <td class="text-center">{{ $user->full_name }}</td>
                        <td class="text-center">{{ $user->phone }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->birthday }}</td>
                        <td class="text-center">{{ $user->role }}</td>
                        <td class="text-center">{{ $user->gender_text  }}</td>
                        <td class="text-center">{{ $user->mkt_id }}</td>
                        <td class="text-center">{{ $user->status }}</td>
                        <td class="text-center">{{ $user->active_text}}</td>
                        <td class="text-center">
                            <a class="btn" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i></a>
                            <a class="btn delete" href="#"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
