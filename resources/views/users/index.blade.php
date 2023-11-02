@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quản lý người dùng</h3>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('users.create') }}"><i
                            class="fa fa-plus-circle"></i> Tạo mới</a></div>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('users.index')}}" method="get" id="gridForm">
                    <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tìm kiếm…" tabindex="1"
                           type="text" id="search" value="{{@$input['search']}}">
                    <div class="col-xs-12 col-md-2">
                        <select id="department_id" name="department_id" class="form-control">
                            <option value="">Tất cả phòng ban</option>
                            @forelse($department as $k => $item)
                                <option {{@$input['branch_id']==$k?'selected':''}} value="{{$k}}">{{$item}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    @if(empty(\Illuminate\Support\Facades\Auth::user()->branch_id))
                    <div class="col-xs-12 col-md-2">
                        <select id="branch" name="branch_id" class="form-control">
                            <option value="">Tất cả chi nhánh</option>
                            @forelse($branchs as $k => $item)
                                <option {{@$input['department_id']==$k?'selected':''}} value="{{$k}}">{{$item}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                        <div class="col-xs-12 col-md-2">
                            <select id="active" name="active" class="form-control">
                                <option value="">Tất cả tài khoản</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Đã khóa</option>
                            </select>
                        </div>
                    @endif
                    <input type="hidden" name="page" id="page">
                    <div class="col-lg-4 col-md-4">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm
                        </button>
                    </div>

                </form>
            </div>
            <div id="registration-form">
                @include('users.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            $('#page').val(pages);
            $('#gridForm').submit();
        });
        $(document).on('change', '.check', function () {
            let value = this.checked ? 1 : 0;
            console.log(value);
            $.ajax({
                url: "/ajax/active-user/" + $(this).data('id'),
                type: 'POST',
                data: {
                    active: value,
                    // _token: 'I2oyUkzbxy2pMyZfs6idnBIxPoSnFo7CzQmY15xr',
                }
            }).done(function (data) {
                alertify.success('Cập nhật tk thành công !');
            });
        })

    </script>
@endsection
