@extends('layout.app')
@section('content')
    <style>
        .inputfile {
            /*width: 0.1px;*/
            /*height: 0.1px;*/
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .inputfile + label {
            cursor: pointer;
        }
        .title-small{
            font-size: 13px;
            color: #999;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hiệu quả chiến dịch</h3>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('statistic-campaigns.index')}}" method="get" id="gridForm">
                    <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tìm kiếm…" tabindex="1"
                           type="text" id="search" value="{{@$input['search']}}">
                    <input type="hidden" name="page" id="page">
                    <div class="col-xs-12 col-md-3">
                        <select name="campaign_id" id="campaign_search" class="form-control select2">
                            <option value="">--Chọn chiến dịch--</option>
                            @forelse($campaigns as $k => $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                    </div>

                </form>
            </div>
            <div id="registration-form">
                @include('campaigns.statistic.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', 'a.page-link', function (e) {
            e.preventDefault();
            let pages = $(this).attr('href').split('page=')[1];
            $('#page').val(pages);
            $('#gridForm').submit();
        });
        $(document).on('change', '.check', function () {
            let value = this.checked ? 1 : 0;
            console.log(value);
            $.ajax({
                url: "/ajax/active-user/" + $(this).data('id'),
                type: 'POST',
                data: {
                    active: value,
                    // _token: 'I2oyUkzbxy2pMyZfs6idnBIxPoSnFo7CzQmY15xr',
                }
            }).done(function (data) {
                alertify.success('Cập nhật tk thành công !');
            });
        })
        var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });
        });
    </script>
@endsection
