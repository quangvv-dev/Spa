<div id="myKanban"></div>
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
                    let abc = data.description.replaceAll("--", '\n');
                    $('#name').val(data.name).change();
                    $('#date_from').val(data.date_from).change();
                    $('#time_from').val(data.time_from).change();
                    $('#time_to').val(data.time_to).change();
                    $('#description').html(abc).change();
                    $('#myModal').modal('show');
                }
            })
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
                        'id': '{{$item->id}}',
                        'title': '<img class="img-card" src="{{$item->avatar?:"/assets/images/brand/logo.png"}}"> {{$item->name}}',

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
                        'id': '{{$item->id}}',
                        'title': '<img class="img-card" src="{{$item->avatar?:"/assets/images/brand/logo.png"}}"> {{$item->name}}',

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
                            'id': '{{$item->id}}',
                            'title': '<img class="img-card" src="{{$item->avatar?:"/assets/images/brand/logo.png"}}"> {{$item->name}}',

                        },
                    @endforeach

                    @endif
                ]
            }
        ]
    });
</script>
