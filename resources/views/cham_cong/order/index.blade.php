@extends('layout.app')
@section('content')
    <style>
        .txt-dotted {
            border: 1px solid transparent;
            border-bottom: dotted 1px #999;
            width: 100%;
            padding: 0px;
        }

        .users-summary {
            display: inline-block;
            width: 30px;
            height: 30px;
        }

        .users-summary .userlink {
            background: rgb(230, 230, 230);
            overflow: hidden;
            text-indent: -10000px;
            border-radius: 50%;
            margin-left: 0;
        }

        .beacon-green, .beacon-red {
            opacity: 0.8;
            width: 120px;
            color: #fff !important;
            border-radius: 4px;
            font-size: .8em;
            display: inline-flex;
            padding: 5px 10px;
            justify-content: center;
        }

        .beacon-green {
            background: #49CE7E;
        }

        .beacon-red {
            background: #FB5E5A;
        }

        .nav-link.active {
            font-weight: bold;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn từ</h3></br>
                <form action="{{url()->current()}}" method="get" id="gridForm">
                    <div class="ml-5">
                        <input type="text" name="searchName" class="form-control searchName" style="height: 33px;"
                               placeholder="Tìm kiếm">
                    </div>
                </form>

            </div>
            <div id="registration-form">
                <div class="mt-3 mb-3">
                    <nav class="nav">
                        <a class="nav-link searchStatus active" href="#" data-status="">Tất cả <span class="count">({{$count}})</span></a>
                        <a class="nav-link searchStatus" href="#" data-status="0">Chờ duyệt </a>
                        <a class="nav-link searchStatus" href="#" data-status="1">Đã duyệt </a>
                        <a class="nav-link searchStatus" href="#" data-status="2">Không duyệt </a>

                        @if(\Illuminate\Support\Facades\Auth::user()->department_id==\App\Constants\DepartmentConstant::ADMIN)
                            <button class="btn btn-success acceptAll mr-1">Duyệt đơn</button>
                        @endif


                        <a href="/approval/order/create/1">
                            <button class="btn btn-secondary mr-1"><i class="fa fa-plus"></i> Đơn nghỉ</button>
                        </a>
                        <a href="/approval/order/create/2">
                            <button class="btn btn-primary"><i class="fa fa-plus"></i> Đơn checkin/checkout</button>
                        </a>
                    </nav>
                </div>
                <div class="table-responsive">
                    @include('cham_cong.order.ajax')
                </div>

            </div>
            <!-- table-responsive -->
        </div>
    </div>
    @include('cham_cong.order.modal_accept')
@endsection
@section('_script')
    <script>
        $(function () {
            $(".draggable").draggable();
        });
        $(document).on('click', '#checkAll', function () {
            if (this.checked) {
                $('input:checkbox[getdataitem]').not(this).prop('checked', true);
            } else {
                $('input:checkbox[getdataitem]').not(this).prop('checked', false);
            }
        })

        $(document).on('click','.acceptAll',function () {
            let favorite = [];
            $.each($("input[getdataitem]:checked"), function () {
                favorite.push($(this).val());
            });
            if(favorite.length < 1){
                alertify.warning('Vui lòng chọn đơn');
                return;
            } else {
                $('#myModalDuyet').modal('show');
            }
        })
        $(document).on('click','.submitAccept',function () {
            let favorite = [];
            $.each($("input[getdataitem]:checked"), function () {
                favorite.push($(this).val());
            });
            let type = $(this).data('type');

            $.ajax({
                url:'/approval/update-array-order',
                method: 'put',
                data:{
                    array_id: favorite,
                    type: type
                },
                success:function (data) {
                    if(data){
                        alertify.success('Cập nhật thành công !')
                    } else {
                        alertify.error('Cập nhật không thành công !')
                    }
                }
            })
        })


        $(document).on('keyup', '.searchName', function () {
            let abc = {'searchName': $(this).val()};
            doSearch(abc);
            // doSearch()
        })

        $(document).on('click', '.searchStatus', function () {
            let abc = {'status': $(this).data('status')};
            $('.searchStatus').removeClass('active');
            $(this).addClass('active');
            search(abc);
        })

        function search(data) {
            $.ajax({
                url: `/approval/order`,
                data: data,
                success: function (data1) {
                    $('.table-responsive').html(data1);
                }
            })
        }

        let delayTimer;

        function doSearch(data) {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function () {
                search(data)
            }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
        }
    </script>
@endsection
