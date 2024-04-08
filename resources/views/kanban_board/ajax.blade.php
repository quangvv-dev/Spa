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
                    console.log(data);
                    // let abc = data.description.replaceAll("--", '\n');
                    let link = '/customers/'+data.customer.id;
                    let full_name = data.user.full_name ??'';
                    $('#name').val(data.name).change();
                    $("a[href]").attr("href",link);
                    $('.name-customer').html(data.customer.full_name).change();
                    $('.phone-customer').val(data.customer.phone).change();
                    $('#user_id').val(full_name).change();
                    $('#date_from').val(data.date_from).change();
                    $('#time_from').val(data.time_from).change();
                    $('#time_to').val(data.time_to).change();
                    $('#description').html(data.description).change();
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
                        'title': '<img class="img-card" src="{{isset($item->user)&& $item->user->avatar?$item->user->avatar:setting('logo_website')}}"> <span style="color:{{@$color[@$item->customer->status_id]}}">{{$item->name}}</span>',

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
                        'title': '<img class="img-card" src="{{isset($item->user) && $item->user->avatar?$item->user->avatar:setting('logo_website')}}"> {{$item->name}}',

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
                            'title': '<img class="img-card" src="{{isset($item->user) && $item->user->avatar?@$item->user->avatar:setting('logo_website')}}"> {{$item->name}}',

                        },
                    @endforeach

                    @endif
                ]
            }
        ]
    });
</script>
