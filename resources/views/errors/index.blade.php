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
                <h3 class="card-title">Quản lý lỗi</h3>
                <div class="col">
                    <a class="right btn btn-primary btn-flat" href="{{ route('users.create') }}"><i
                            class="fa fa-plus-circle"></i> Tạo mới</a>
                </div>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('users.index')}}" method="get" id="gridForm">
                    <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tìm kiếm…" tabindex="1"
                           type="text" id="search" value="{{@$input['search']}}">

                    <div class="col-xs-12 col-md-2">
                        <select id="active" name="active" class="form-control">
                            <option value="">Tất cả tài khoản</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Đã khóa</option>
                        </select>
                    </div>
                    <input type="hidden" name="page" id="page">
                    <div class="col-lg-4 col-md-4">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                    </div>

                </form>
            </div>
            <div id="registration-form">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div id="registration-form">
                                    <div class="table card-table table-vcenter text-nowrap table-primary"
                                         style="width: 100%; overflow-x: auto;">
                                        <table class="table-sortable1 table table-custom">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width: 30px;">STT</th>
                                                <th class="text-center">Tên</th>
                                                <th class="text-center">Phân loại</th>
                                                <th class="text-center nowrap">
                                                    <a id="add_new_location" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody id="sortable1">
                                            @if(count($data))
                                                @foreach($data as $k =>$item)
                                                    <tr data-id="{{$item->id}}">

                                                        <td class="text-center">
                                                            {{$k+1}}
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" class="name txt-dotted form-control" value="{{$item->name}}">
                                                        </td>
                                                        <td class="text-center">
                                                            {!! Form::select('type', \App\Models\Errors::labelType, @$item->type, array('class' => 'form-control location select-gear', 'placeholder' => '--Phân loại--')) !!}
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="btn save" href="javascript:void(0)"
                                                               data-id="{{$item->id}}">
                                                                <i class="fa fa-save"></i>
                                                            </a>
                                                            <a class="btn delete" href="javascript:void(0)" data-url="{{route('errors.reason',$item->id)}}">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
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


