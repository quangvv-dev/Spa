@extends('layout.app')
@section('content')
    <style>
        .inputfile {
            /*width: 0.1px;*/
            /*height: 0.1px;*/
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .inputfile + label {
            cursor: pointer;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title bold">Quản lý lỗi</h3>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('errors.reason.index')}}" method="get" id="gridForm">
                    <input class="form-control col-md-2 col-xs-12" name="name" placeholder="Tìm kiếm…" tabindex="1"
                           type="text" id="search" value="{{@$input['search']}}">

                    <div class="col-xs-12 col-md-2">
                        <select id="active" name="type" class="form-control">
                            <option value="">--Tất cả--</option>
                            @foreach(\App\Models\Errors::labelType as $k => $item)
                                <option value="{{$k}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="page" id="page">
                    <div class="col-lg-4 col-md-4">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <div id="registration-form">
                @include('errors.reason.ajax')
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
        $(document).on('click', '.save', function () {
            let id = $(this).data('id');
            let data = {
                name :$(this).closest('tr').find('.name').val(),
                type :$(this).closest('tr').find('.type').val(),
            }
            console.log(data);
            $.ajax({
                url: '/errors/reason/'+id,
                data:data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        alertify.success('Cập nhật bản ghi thành công !');
                    }
                }
            })
        })
        $(document).on('click', '#add_new_location', function () {
            $.ajax({
                url: '{{route('errors.reason.store')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                    console.log(data);
                }
            })
        })
    </script>
@endsection


