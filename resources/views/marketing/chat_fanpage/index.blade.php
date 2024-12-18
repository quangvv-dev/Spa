@extends('layout.app')
@section('content')
    <style>
        .bg-transparent {
            height: 92px;
        }

        .checkbox {
            width: 18px;
            position: absolute;
            right: 4%;
            bottom: 3%;
        }

        .f-page {
            padding-left: 95px;
        }
        .username{
            position: absolute;
            bottom: 0;
            left: 0;
        }
        .delete-group{
            position: absolute;
            right: 6px;
            font-size: 14px;
        }
        body{
            overflow: hidden;
        }
        .multipage-selectedCount {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 12px;
            background: #E6F7FF;
            border: #E6F7FF;
            border-radius: 4px;
            padding: 1px 8px;
            color: #1890ff;
        }
        .body-multi{
            overflow-x: hidden;
            overflow-y: scroll;
            height: 85vh;
        }
    </style>
    <div class="card">
        <form action="{{url()->current()}}" method="get" id="gridForm">
            <div class="card-header fix-header bottom-card add-paginate">
                <div class="row" style="width: 100%">
                    <h4 class="col-lg-2">2.10 Chat Fanpage</h4>
                    <div class="col-lg-2 col-md-6">
                        <select name="mkt_id" id="" class="select2"
                                data-placeholder="-- Chọn MKT --">
                            <option></option>
                            @forelse($mkts as $item)
                                <option value="{{$item->id}}">{{$item->full_name}}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="searchPageId" class="form-control square"
                                   placeholder="ID fanpage">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="searchName" class="form-control square"
                                   placeholder="Tên fanpage">
                        </div>
                    </div>
                    <button class="btn btn-primary searchData" style="height: 38px;"><i class="fa fa-search"></i> Tìm kiếm
                    </button>
                </div>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li class="dropdown dropdown-custom nav-item">
                            <i style="font-size: 20px;cursor: pointer"
                               class="dropdown-toggle nav-link fa fa-filter pointer openModal"
                               aria-expanded="true"></i>
                        </li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
        </form>
        <div class="card-content collapse show">
            <div class="card-body body-multi">
                <div class="row" id="registration-form">
                    @include('marketing.chat_fanpage.ajax')
                </div>
                @include('marketing.chat_fanpage.modal_multi_page')
            </div>
        </div>
    </div>
    <input type="hidden" class="arrPage" value="{{$fanpages}}">
@endsection
@section('_script')
    <script>
        let group_id = 0;
        let arr_curent_group = [];
        $(document).on('click','.openModal',function () {
            $('#modalMultiPage').modal('show');
            $('#modalMultiPage .group-name-key-0').click();
        })

        $(document).on('click','.addTab',function () {
            $.ajax({
                url:'/marketing/add-group',
                method:'post',
                success:function (data) {
                    if(data){
                        pushData(data);
                        let html = `
                                <a class="nav-item nav-link group-name" data-name="Group new" data-id="`+ data.id +`" data-toggle="tab" role="tab" aria-selected="true">
                                    Group new
                                    <span class="delete-group" data-id="`+ data.id +`">x</span>
                                </a>
                               `
                        $('.listTab').append(html);
                    }
                }
            })

        })

        function pushData(item){
            let data_old = $('.groupMulti').val();
            if(data_old){
                data_old = JSON.parse(data_old);
            } else {
                data_old = [];
            }
            data_old.push(item);

            let data_new = JSON.stringify(data_old);
            $('.groupMulti').val(data_new);
        }

        $(document).on('click', '.group-name', function (e) {
            group_id = $(this).data('id');
            arr_curent_group = [];
            $('input:checkbox').not(this).prop('checked', false);
            $.ajax({
                url:'get-data-group/'+group_id,
                success:function (data) {
                    if(data && data.page_ids != '[]'){
                        let pages = JSON.parse(data.page_ids);
                        if(pages.length>0){
                            arr_curent_group = pages;
                            pages.forEach(f=>{
                                $('.' + f).prop('checked', true)
                            })
                        }else {
                            arr_curent_group = [];
                        }
                        $('.multipage-selectedCount').html(pages.length);
                    } else {
                        $('.multipage-selectedCount').html(0);
                    }
                }

            })
        });

        $(document).on('dblclick', '.group-name', function (e) {
            $(this).empty();
            let name = $(this).data('name');
            let id = $(this).data('id');
            let html = '';
            html += `<input data-id=` + id + ` class="group-name-result form-control" value="` + name + `" \> `;
            $(this).html(html);
        });

        $(document).on('focusout', '.group-name-result', function (e) {
            let name = $(this).val();
            let id = $(this).data('id');
            let el = $(this);
            $(this).closest('a').data('name',name);
            $.ajax({
                url: "/marketing/update-group",
                method: "put",
                data: {
                    id: id,
                    name: name,
                },
                success: function (data) {
                    let html = `
                            `+name+`
                            <span class="delete-group" style="display: none" data-id="`+ id +`">x</span>
                        `
                    el.closest('a').html(html).attr('data-name',name).change();
                }
            })
        });
        $(document).on('click','.delete-group',function () {
            let el = $(this);
            swal({
                title: 'Bạn có muốn xóa ?',
                text: "Nếu bạn xóa tất cả các thông tin sẽ không thể khôi phục!",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'OK'
            }, function () {
                $.ajax({
                    url: "/marketing/delete-group/"+el.data('id'),
                    method: "delete",
                    success: function (data) {
                        el.closest('a').remove();
                        location.reload();
                    }
                })
            })
        })

        $(".group-name").mouseover(function () {
            $(this).find('.delete-group').show();
        });
        $(".group-name").mouseout(function () {
            $(this).find('.delete-group').hide();
        });


        $(document).on('click','.checkPage',function () {
            let checked = $(this).is(":checked");
            let page_id = $(this).val();
            if(checked){
                arr_curent_group.push(page_id);
            } else {
                arr_curent_group = arr_curent_group.filter(fb=>fb != page_id);
            }

            $.ajax({
                url: "/marketing/update-group",
                method: "put",
                data: {
                    id: group_id,
                    arr_page: arr_curent_group,
                },
                success: function (data) {
                    if(data){
                        $('.multipage-selectedCount').html(arr_curent_group.length)
                    }
                }
            })
        })

        $(document).on('click','.submitMultiPage',function () {
            $.ajax({
                url:'get-data-group/'+group_id,
                data:{
                    type: 'submitPage'
                },
                success:function (data) {
                    if(data && data.length > 0){
                        let arr_page_id = JSON.stringify(data);
                        localStorage.setItem("arr_page_id", arr_page_id);
                        location.href = `/marketing/chat-multi-page`
                    }
                }

            })

        })


        $( ".quickSearchPage" ).keyup(function() {
            let value = $(this).val();
            let arr_page1 = $('.arrPage').val();
            arr_page1 = JSON.parse(arr_page1);
            doSearch(value,arr_page1);
        });

        let delayTimer;
        function doSearch(text,arr_page1) {
            clearTimeout(delayTimer);

            delayTimer = setTimeout(function() {
                html = '';
                if(arr_page1.length>0){
                    arr_page1.forEach(f=>{
                        let re = new RegExp(`${text}`, 'gi');
                        if (f.name.match(re) ||f.page_id.match(re) ) {
                            let avatar = f.avatar ? f.avatar  :'';
                            let checked = arr_curent_group.findIndex(fi=>fi == f.page_id) > -1? 'checked' : '';
                            let full_name = f.user && f.user.full_name ? f.user.full_name : '';
                            html += `
                                <div class="col-4">
                                    <div class="card border-info box-shadow-0 bg-transparent">
                                        <div class="card-content">
                                            <img src="`+avatar+`" alt="element 04" width="90" class="float-left img-fluid">
                                            <div class="card-body pt-3 f-page">
                                                <p class="pointer">`+f.name+`</p>
                                                <p class="small-tip">`+full_name+` (`+f.page_id+`)</p>
                                            </div>
                                            <input type="checkbox" class="checkbox checkPage `+f.page_id+`" `+checked+`
                                                   value="`+f.page_id+`" data-token="`+f.access_token+`"
                                                   data-name="`+f.name+`">
                                        </div>
                                    </div>
                                </div>
                            `
                        }else{
                            // console.log('ngon ngay1');
                        }
                    })
                    $('.forEach').html(html)
                }
            }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
        }
    </script>

@endsection
