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
                <h3 class="card-title">DS khách hàng chiến dịch</h3>
            </div>
            <div class="card-header">
                <form class="row col-12" action="{{route('customer-campaign.index')}}" method="get" id="gridForm">
                    <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tìm kiếm SĐT…" tabindex="1"
                           type="text" value="{{@$input['search']}}">
                    <div class="col-xs-12 col-md-3">
                        <select name="campaign_id" id="campaign_search" class="form-control">
                            <option value="">--Chọn chiến dịch--</option>
                            @forelse($campaigns as $k => $item)
                                <option data-sale="{{$item->SaleRelation}}" value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <select name="status" class="form-control select2">
                            <option value="">--Chọn trạng thái--</option>
                            @forelse(\App\Models\CustomerCampaign::statusLabel as $k => $item)
                                <option value="{{$k}}">{{$item}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::ADMIN)
                        <div class="col-xs-12 col-md-2">
                            <select name="sale_id" id="sale_id" class="form-control select2">
                                <option value="">--Người phụ trách--</option>
                            </select>
                        </div>
                    @else
                        <div class="col-xs-12 col-md-2">
                            <select name="branch_id" class="form-control select2">
                                <option value="">--Chọn chi nhánh--</option>
                                @forelse($branchs as $k => $item)
                                    <option value="{{$k}}">{{$item}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    @endif
                    <input type="hidden" name="page" id="page">
                    <div class="col-lg-2 col-md-2">
                        <button type="submit" class="btn btn-primary"> Tìm kiếm</button>
                    </div>

                </form>
            </div>
            <div id="registration-form">
                @include('customer_campaign.ajax')
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
        $(document).on('change', '.status', function (e) {
            let status = $(this).val();
            $.ajax({
                url: "/update-status-campaign/" + $(this).data('id'),
                method: "POST",
                data: {
                    status: status,
                }
            }).done(function (data) {
                alertify.success('Cập nhật trạng thái thành công !');
            });
        });
        $(document).on('change', '#campaign_search', function (e) {
            let sale = $("#campaign_search option:selected").data('sale');
            let option = ` <option value="">--Người phụ trách--</option>`;
            if(sale && sale.length) {
                sale.forEach(item => {
                    option += `<option value="` + item.id + `">` + item.full_name + `</option>`
                })
            }
            $('#sale_id').html(option);
        });
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
