@extends('layout.app')
@section('content')
<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Full color variations</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap table-primary" >
                <thead  class="bg-primary text-white">
                <tr>
                    <th class="text-white">ID</th>
                    <th class="text-white">Name</th>
                    <th class="text-white">Position</th>
                    <th class="text-white">Salary</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Joan Powell</td>
                    <td>Associate Developer</td>
                    <td>$450,870</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Gavin Gibson</td>
                    <td>Account manager</td>
                    <td>$230,540</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Julian Kerr</td>
                    <td>Senior Javascript Developer</td>
                    <td>$55,300</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Cedric Kelly</td>
                    <td>Accountant</td>
                    <td>$234,100</td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>Samantha May</td>
                    <td>Junior Technical Author</td>
                    <td>$43,198</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- table-responsive -->
    </div>
</div>
@endsection
