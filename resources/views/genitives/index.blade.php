@extends('layout.app')
<style>
    .txt-dotted{
        border: 1px solid transparent;
        border-bottom: dotted 1px #999;
        width: 100%;
        padding: 0px;
    }
</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div id="registration-form">
                <div class="table card-table table-vcenter text-nowrap table-primary"
                     style="width: 100%; overflow-x: auto;">
                    <table class="table-sortable1 table table-custom">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">STT</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Mô tả</th>
                            <th class="text-center">Cập nhật</th>
                            <th class="text-center nowrap">
                                <a id="add_new_status" style="cursor: pointer"><i class="fa fa-plus"></i> Thêm</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="sortable1">
                        @if(count($genitives))
                            @foreach($genitives as $k =>$item)
                                <tr data-id="{{$item->id}}">

                                    <td class="text-center">
                                        {{$k+1}}
                                    </td>
                                    <td class="text-center"><input type="text" class="name txt-dotted" value="{{$item->name}}">
                                    </td>
                                    <td class="text-center">
                                        <textarea rows="2" type="text" class="description txt-dotted">{{$item->description}}</textarea>
                                    </td>
                                    <td class="text-center">{{$item->updated_at}}</td>
                                    <td class="text-center">
                                        <a class="btn save-status" href="javascript:void(0)"
                                           data-id="{{$item->id}}">
                                            <i class="fa fa-save"></i>
                                        </a>
                                        <a class="btn delete" href="javascript:void(0)" data-url="{{'genitives/'.$item->id}}">
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
@endsection
@section('_script')
<script>
    $(document).on('click', '#add_new_status', function () {
        $.ajax({
            url: '{{route('genitives.store')}}',
            method: 'POST',
            success: function (data) {
                if (data) {
                    location.reload();
                }
            }
        })
    })

    $(document).on('click', '.save-status', function () {
        let id = $(this).data('id');
        let data = {
            name :$(this).closest('tr').find('.name').val(),
            description :$(this).closest('tr').find('.description').val(),
        }
        $.ajax({
            url: 'genitives/'+id,
            data:data,
            method: 'PUT',
            success: function (data) {
                if (data) {
                    location.reload();
                }
            }
        })
    })
</script>
@endsection
