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
        .users-summary .userlink{
            background: rgb(230, 230, 230);
            overflow: hidden;
            text-indent: -10000px;
            border-radius: 50%;
            margin-left: 0;
        }
        .beacon-green,.beacon-red {
            opacity: 0.8;
            width: 120px;
            border: 1px solid #36c870;
            color: #fff!important;
            border-radius:4px;
            font-size: .8em;
            display: inline-flex;
            padding: 5px 10px;
            justify-content: center;
        }
        .beacon-green{
            background: #49CE7E;
        }
        .beacon-red {
            background: #FB5E5A;
        }
        .nav-link.active{
            font-weight: bold;
        }
        .pointer{
            cursor: pointer;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn từ</h3></br>
                <form action="{{url()->current()}}" method="get" id="gridForm">
                    <div class="ml-5">
                        <input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">
                    </div>
                </form>

            </div>
            <div id="registration-form">
                {{--<div class="mt-3 mb-3">--}}
                    {{--<nav class="nav">--}}
                        {{--<a class="nav-link active" href="#">Tất cả (11)</a>--}}
                        {{--<a class="nav-link" href="#">Chờ duyệt (12)</a>--}}
                        {{--<a class="nav-link" href="#">Đã duyệt (45)</a>--}}
                        {{--<a class="nav-link" href="#">Không duyệt</a>--}}
                    {{--</nav>--}}
                {{--</div>--}}
                @include('cham_cong.statistic.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
    @include('cham_cong.statistic.modal')
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


        $(document).on('click','.showModal',function () {
            $('#myModal').modal('show');
        })
    </script>
@endsection
