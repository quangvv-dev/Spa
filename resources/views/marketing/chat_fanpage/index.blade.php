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
                            <input type="text" name="page_id" class="form-control square"
                                   placeholder="ID fanpage">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control square"
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
                               class="dropdown-toggle nav-link fa fa-filter pointer"
                               aria-expanded="true"></i>
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up badgePage">0</span>
                            <div class="dropdown-menu-custom dropdown-menu dropdown-menu-right show"
                                 style="padding: 10px">
                                <div class="row listFanpageCheck"></div>
                            </div>
                        </li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
        </form>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="row">
                    <button class="btn btn-info chatMessage" style="margin: 10px">Chat ngay</button>
                    @include('marketing.chat_fanpage.ajax')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>

        $(document).ready(function () {
            function getCookie(cname) {
                let name = cname + "=";
                let ca = document.cookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }



            $(function(){
                let arr = getCookie("arr_page_id");
                if(arr){
                    arr = JSON.parse(arr);
                    arr_page = arr;
                    returnViewCheckPage(arr)
                }
            })

            let arr_page = [];
            $(document).on('click','.checkbox',function () {
                let checked = $(this).is(":checked");
                let page_id = $(this).val();
                let page_token = $(this).data('token');
                let page_name = $(this).data('name');
                if(checked){
                    if(arr_page.length > 0){
                        const index = arr_page.findIndex(f => f.id === page_id);
                        if(index > -1){
                            let checked = $('.' + page_id).is(":checked");
                            if(!checked){
                                $('.' + page_id).prop('checked', true);
                            }
                        } else {
                            let data = {
                                id: page_id,
                                token : page_token,
                                name: page_name
                            }
                            arr_page.push(data);
                        }
                    } else {
                        let data = {
                            id: page_id,
                            token : page_token,
                            name: page_name
                        }
                        arr_page.push(data);
                    }


                } else {
                    arr_page = arr_page.filter(f=>{return f.id != page_id})
                }
                returnViewCheckPage(arr_page);
            })
            function returnViewCheckPage(arr_page){
                let html = '';
                if(arr_page.length > 0){
                    arr_page.forEach(f=>{
                        html+=`
                        <div class="col-6 item">
                             <label> <input type="checkbox" class="`+f.id+`" checked getDataItem value="`+f.id+`" data-name="`+f.name+`" data-token="`+f.token+`"> &nbsp;`+f.name+`</label>
                        </div>
                    `
                        $('.' + f.id).prop('checked', true);
                    })
                }
                $(".listFanpageCheck").html(html);
                setTimeout(function () {
                    $('.badgePage').html(arr_page.length)
                },400)
            }

            $(document).on('click','.chatMessage', function () {
                let favorite = [];
                $.each($("input[getDataItem]:checked"), function () {
                    let data = {
                        id:$(this).val(),
                        token:$(this).data('token'),
                        name:$(this).data('name')
                    }
                    favorite.push(data);
                });

                if(favorite.length == 1){
                    let page_id = favorite[0].id;
                    location.href = `/marketing/chat-messages/${page_id}`
                } else if(favorite.length > 1){
                    let arr_page_id = JSON.stringify(favorite);
                    document.cookie = `arr_page_id = ${arr_page_id};max-age=31536000;path=/`;
                    location.href = `/marketing/chat-multi-page`
                } else {
                    return;
                }

            })

            $(document).on('click', '.dropdown-custom', function () {
                $(this).toggleClass('show');
            })
            $(document).on('click.bs.dropdown.data-api', 'label', function (e) {
                e.stopPropagation();
            });
        })


    </script>
@endsection
