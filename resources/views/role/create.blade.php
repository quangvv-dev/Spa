@extends('layout.app')
@section('content')
    <div class="row col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin quản trị viên</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => route('roles.update',$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('roles.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            @include('role.form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        // $(document).ready(function () {
        function checkAll(baseId, itemId) {
            var baseCheck = document.getElementById(baseId).checked;
            var item = document.getElementById(itemId + '1');
            var i = 1;

            while (item != null) {
                if (item.disabled == false) {
                    item.checked = baseCheck;
                }
                i = i + 1;
                item = document.getElementById(itemId + i);
            }
        }

        // })
        $('#type').on('change', function () {
            var id = $(this).val();
            $.ajax({
                url: '/admincms/admin/ajax/get-category',
                type: 'GET',
                data: {
                    id: id,
                },
                success: function (data) {
                    if (data.length > 0) {

                        var row = $('body').find('#parent_id');
                        html = '';
                        $.each(data, function (i, v) {
                            html += '<option value="0">Không có</option><option value="' + v.id + '">' + v.name + '</option>';
                            row.html(html);
                        });
                    } else {
                        html = `<option value="0">Không có</option>`;
                        var row = $('body').find('#parent_id');
                        row.html(html);
                    }
                },
                error: function () {
                    alert("Lỗi, xin kiểm tra lại");
                }
            })
        })
    </script>
@endsection
