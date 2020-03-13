@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('status.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                <div class="col-md-2">
                    {!! Form::select('type',$types_pluck, null, array('class' => 'form-control header-search','required' => true)) !!}
                </div>
            </div>

            <div id="registration-form">
                @include('status.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $('.card-header').on('keyup','.header-search',function(e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('status/') }}",
                method: "get",
                data:{search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

                sortable();
                updateColor();
            });
        });
        $('.card-header').on('change','.header-search',function() {
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('status/') }}",
                method: "get",
                data:{search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

                sortable();
                updateColor();
            });
        });
        
        
        // sortable update position
        function sortable(){
            $( "table tbody" ).sortable({
                stop: function( event, ui ) {
                    var rows = $('.table tbody tr');
                    var dataPosition = [];
                    for (var r = 0; r < rows.length; r++) {
                        $(rows[r]).attr('data-position',r)
                        dataPosition.push({
                            id : $(rows[r]).attr('data-id'),
                            position : r
                        })
                    }
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ Url('ajax/updatePostion/') }}",
                        method: "post",
                        dataType:'json',
                        data:{
                            data : dataPosition
                        }
                    }).done(function (data) {
                        console.log('ok')
                    });
                }
            });
        }


        function debounce(func, wait) {
            var timeout;

            return function() {
                var context = this,
                    args = arguments;

                var executeFunction = function() {
                func.apply(context, args);
                };

                clearTimeout(timeout);
                timeout = setTimeout(executeFunction, wait);
            };
        };  

        var handleClick = debounce(function (e) {
            var id_update = $(this).closest('tr').attr('data-id');
            var color_update = e.target.value;
            console.log(23432,id_update);
            
            $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ Url('ajax/updateColor/') }}",
                        method: "post",
                        dataType:'json',
                        data:{
                            id : id_update,
                            color: color_update
                        }
                    }).done(function (data) {
                        console.log('ok')
                    });

        }, 500);


        function updateColor(){
            $('.bgcolor').on('change', handleClick);
        }



    </script>
@endsection
