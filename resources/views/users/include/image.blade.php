@extends('layout.app')
@section('_style')
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <style>
        a.nav-link.active {
            font-weight: 600;
        }
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .inputfile + label {
            /*font-size: 1.25em;*/
            /*font-weight: 700;*/
            /*color: white;*/
            /*background-color: black;*/
            /*display: inline-block;*/
            cursor: pointer;
        }

        /*.inputfile:focus + label,*/
        /*.inputfile + label:hover {*/
        /*    background-color: red;*/
        /*}*/

    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1 ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="nav-item">
                            <a href="{{route('users.edit',$user->id)}}" class="nav-link" >Thông tin tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('personal/salary/'.$user->id)}}">Bảng lương</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Hồ sơ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{url('personal/images/'.$user->id)}}">Hợp đồng (file)</a>
                        </li>
                    </ul>
                </div>
            </div>

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
                                            <th class="text-center">Tài liệu</th>
                                            <th class="text-center">Đường dẫn</th>
                                            <th class="text-center">Định dạng</th>
                                            <th class="text-center nowrap">
                                                <a id="add_new" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="sortable1">
                                        @if(count($user->personal_image))
                                            @foreach($user->personal_image as $k =>$item)
                                                <form action="{{route('personal_image.update',$user->id)}}" method="put">
                                                    @csrf
                                                <tr>
                                                    <td class="text-center">{{$k+1}}</td>
                                                    <td class="text-center">
                                                        <select id="branch_id" name="branch_id" class="form-control select2">
                                                            <option value="">--Chọn loại tài liệu--</option>
                                                            @forelse($labels as  $label)
                                                                <option
                                                                    {{$label==$item->name?'selected':''}} value="{{$label}}">{{$label}}
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="name txt-dotted form-control" value="{{$item->link}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" readonly class="name txt-dotted form-control" value="{{$item->type_file}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="file" name="file" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
                                                        <label for="file" class="tooltip-nav">
                                                            <span><i class="fa fa-upload"></i></span>
{{--                                                            >--}}
{{--                                                            <span class="tooltiptext">Upload</span>--}}
                                                        </label>
                                                        <a class="btn save" href="javascript:void(0)" data-id="{{$item->id}}">
                                                            <i class="fa fa-save"></i>
                                                        </a>
                                                        <a class="btn delete" href="javascript:void(0)" data-url="{{'location/'.$item->id}}">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </form>
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
@endsection
@section('_script')
<script>
    $(document).on('click', '#add_new', function () {
        $.ajax({
            url: '{{route('personal_image.store',$user->id)}}',
            method: 'POST',
            success: function (data) {
                location.reload();
            }
        })
    });
    $(document).on('click', 'save', function () {
        let fỏ
        $.put($(this).attr('action'), $(this).serialize(), function (data) {
                    console.log(data,'aaaa');
                });
    });
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });


</script>
@endsection

