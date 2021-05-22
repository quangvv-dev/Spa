@extends('layout.app')
<link rel="stylesheet" href="{{asset('assets/plugins/kanban-board/jkanban.min.css')}}"/>
<style>
    body {
        font-family: "Lato";
        margin: 0;
        padding: 0;
    }

    #myKanban {
        overflow-x: auto;
        padding: 20px 0;
    }

    .success {
        background: #00b961;
    }

    .info {
        background: #2a92bf;
    }

    .warning {
        background: #f4ce46;
    }

    .error {
        background: #fb7d44;
    }

    .custom-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 7px 15px;
        margin: 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .kanban-item {
        font-size: 14px;
        color: black;
        padding: 11px;
        margin-bottom: 6px;
    }

    .kanban-title-board {
        color: #fff;
    }

    .kanban-container {
        width: 100% !important;
        display: flex;
        justify-content: center;
    }

    .kanban-board {
        min-width: 31% !important;
    }

    @media only screen and (max-width: 1920px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 68vh;
            overflow-y: auto;
        }
    }

    @media only screen and (max-width: 1440px) {
        .kanban-drag {
            padding: 6px !important;
            max-height: 60vh;
            overflow-y: auto;
        }
    }

</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chăm sóc khách hàng</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('category.create') }}"><i
                            class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div id="registration-form">
                <div id="myKanban"></div>
                @include('kanban_board.modal')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@php
    if(count($docs))
        $new =[];
        $done =[];
        $fail =[];
        foreach($docs as $item){
        if ($item->task_status_id==1)
        $new[]=['id'=>$item->id,'title'=>$item->name];
        if ($item->task_status_id==2)
        $fail[]=['id'=>$item->id,'title'=>$item->name];
        if ($item->task_status_id==3)
        $done[]=['id'=>$item->id,'title'=>$item->name];
        }
@endphp
@section('_script')
    <script src="{{asset('assets/plugins/kanban-board/jkanban.min.js')}}"></script>
    <script>
        var KanbanTest = new jKanban({
            element: '#myKanban',
            gutter: '10px',
            click: function (el) {
                // alert(el.innerHTML);
                // alert(el.dataset.eid)
                $.ajax({
                    url: '/ajax/tasks/' + el.dataset.eid,
                    method: 'GET',
                    success: function (data) {
                        $('#name').val(data.name).change();
                        $('#date_from').val(data.date_from).change();
                        $('#time_from').val(data.time_from).change();
                        $('#time_to').val(data.time_to).change();
                        $('#description').html(data.description).change();
                    }
                })
                $('#myModal').modal('show');
            },
            dropEl: function (el, target, source, sibling) {
                KanbanTest.options.boards.map(function (board) {
                    if (board.id === $(source.parentElement).data("id")) {
                        let status = board.id == "_todo" ? 3 : (board.id == "_done" ? 2 : 3)
                        $.ajax({
                            url: '/ajax/tasks/' + el.dataset.eid,
                            method: 'PUT',
                            data: {task_status_id: status},
                            success: function (data) {
                            }
                        })
                    }
                    ;
                });

            },
            boards: [
                {
                    'id': '_todo',
                    'dragTo': ['_done'],
                    'title': 'Công việc',
                    'class': 'info',
                    'item': [
                            @if(count($new))
                            @foreach($new as $item)
                        {
                            'id': '{{$item['id']}}',
                            'title': '{{$item['title']}}',
                        },
                        @endforeach
                        @endif
                    ]
                },
                {
                    'id': '_done',
                    'dragTo': ['_fail'],
                    'title': 'Hoàn thành',
                    'class': 'success',
                    'item': [
                            @if(count($done))
                            @foreach($done as $item)
                        {
                            'id': '{{$item['id']}}',
                            'title': '{{$item['title']}}',

                        },
                        @endforeach
                        @endif
                    ]
                },
                {
                    'id': '_fail',
                    'dragTo': ['_done'],
                    'title': 'Quá hạn',
                    'class': 'error',
                    'item': [
                            @if(count($fail))
                            @foreach($fail as $item)
                        {
                            'id': '{{$item['id']}}',
                            'title': '{{$item['title']}}',
                        },
                        @endforeach
                        @endif
                    ]
                }
            ]
        });
    </script>
@endsection

