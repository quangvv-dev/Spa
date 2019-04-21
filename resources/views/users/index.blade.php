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
                        <th class="text-white text-center">Name</th>
                        <th class="text-white text-center">Position</th>
                        <th class="text-white text-center">Salary</th>
                        <th class="text-white text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td class="text-center">Joan Powell</td>
                        <td class="text-center">Associate Developer</td>
                        <td class="text-center">$450,870</td>
                        <td class="text-center">
                            <a class="btn" href="#"><i class="fas fa-edit"></i></a>
                            <a class="btn delete" href="#"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
