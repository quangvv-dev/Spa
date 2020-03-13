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
        $(document).on('keyup','.header-search',function(e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('status/') }}",
                method: "get",
                data:{search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
        $(document).on('change','.header-search',function() {
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('status/') }}",
                method: "get",
                data:{search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });


        // sortable update position
        $( function() {
            // var abc = null;
            // var bcd = null;
            $( "table tbody" ).sortable({
                // start: function( event, ui ) {
                //     this.abc = event.originalEvent.target.innerText;
                //     this.bcd = event;
                // },
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
            // $( ".table" ).disableSelection();
        } );


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

        $('.bgcolor').on('change', handleClick);

        // function myFunc(e){
        //     console.log(123,e);
        //     $('#bgcolor').on('change', handleClick);
        // }


        // $(document).on("change" , "#bgcolor" , function(){
        //     // alert($(this).val());
        //         console.log($(this).val());
            
        // });


    </script>
@endsection
