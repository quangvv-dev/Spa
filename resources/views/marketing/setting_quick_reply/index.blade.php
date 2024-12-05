@extends('layout.app')
@section('content')
    <input type="hidden" value="{{$list_quick_reply}}" class="listQuickReply">
    <div class="card">
        {!! Form::open(array('url' => url()->current(), 'method' => 'get', 'id'=> 'gridForm','role'=>'form')) !!}
        <div class="card-header fix-header bottom-card add-paginate">
            <div class="row" style="width: 100%;">
                <h4 class="col-lg-3">2.10 Danh sách trả lời nhanh</h4>
                <div class="col-lg-3 col-md-6">
                    <input name="message" type="text" class="form-control square"
                           placeholder="Tìm kiếm tin nhắn ...">
                </div>
                <button type="submit" class="btn btn-primary searchData" id="btnSearch"><i
                            class="fa fa-search"></i> Tìm kiếm
                </button>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        {{ Form::close() }}
        <div class="card-header fix-header">
            <a href="{{asset('marketing/setting-quick-reply/'.$page_id.'/create')}}">
                <button class="btn btn-primary"><i
                            class="fa fa-plus"></i> Thêm mới
                </button>
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#import"><i
                        class="fa fa-file-excel-o"></i> Tải lên trả lời nhanh
            </button>
            <button class="btn btn-info syncQuickReply"><i
                        class="fa fa-file-excel-o"></i> Đồng bộ trả lời nhanh
            </button>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                @include('marketing.setting_quick_reply.ajax')
                @include('marketing.setting_quick_reply.import')
                @include('marketing.setting_quick_reply.modal_dong_bo')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $("body").on("click", ".delete-item", function () {
            let elt = $(this).parents('tr');
            let data_id = $(this).data('id');
            swal({
                title: 'Bạn có chắc chắn xóa mục này?',
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'OK'
            },function () {
                $.ajax({
                    url: '/marketing/setting-quick-reply/' + data_id,
                    method: 'delete',
                    success: function (data) {
                        if (data && data.success === false) {
                            swal({
                                title: data.message ? data.message : '',
                                type: 'warning'
                            })
                        } else {
                            swal({
                                title: 'Đã xóa thành công!',
                                type: 'success'
                            })
                            elt.remove();
                            setTimeout(function () {
                                // location.reload();
                            }, 1000);
                        }
                    }
                });
            }, function (dismiss) {
            });
        });

        $(document).on('click','.syncQuickReply',function () {
            $('#syncQuickReply').modal('show');
        })

        $(document).on('click', '.checkAllQuick', function () {
            if (this.checked) {
                $('.checkItemQuick').not(this).prop('checked', true);
            } else {
                $('.checkItemQuick').not(this).prop('checked', false);
            }
        })

        $( ".searchQuick" ).keyup(function() {
            let value = $(this).val();
            let arr_quick = $('.listQuickReply').val();
            arr_quick = JSON.parse(arr_quick);
            doSearch(value,arr_quick);
        });

        let delayTimer;
        function doSearch(text,arr_quick) {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                html = '';
                if(arr_quick.length>0){
                    arr_quick.forEach(f=>{
                        let re = new RegExp(`${text}`, 'gi');
                        if (f.message.match(re)) {
                            html += `
                                <li class="list-group-item d-flex align-items-center list-group-item-action pointer">
                                            <div style="width: 38px;"><input type="checkbox" name="list_quick[]" value="`+f.id+`" class="checkItemQuick"></div>
                                            <div style="display: block; width: 86px;">`+f.shortcut+`</div>
                                            <div class="tbl-space" style="width: 62px;"></div>
                                            <div class="">`+f.message.substring(0,120)+`</div>
                                        </li>
                            `
                        }else{
                            // console.log('ngon ngay1');
                        }
                    })
                    $('.forEach').html(html)
                }
            }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
        }
        
        $(document).on('click','.submitSync',function () {
            let page_id_select = $('.pageId').val();
            if(page_id_select){
                console.log(123123)
                $('#syncQuick').submit();
            } else {
                alertify.warning('Vui lòng chọn page')
            }
        })
        
    </script>
@endsection