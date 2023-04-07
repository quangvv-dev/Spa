@extends('layout.app')
@section('content')
        <!-- card actions section start -->
        <div class="card">
            {!! Form::open(array('url' => url()->current(), 'id'=> 'gridForm','role'=>'form')) !!}

            <div class="card-header fix-header bottom-card add-paginate">
                    <div class="col-12">
                        <div class="row" style="align-items: baseline">
                            <h4 class="col-2">Nguồn Landipage</h4>
                            <div class="col-2">
                                {!! Form::select('mkt_id',$marketings, null, array('class' => 'form-control select2','data-placeholder' => 'Chọn mkt')) !!}
                            </div>
                            <div class="col-2">
                                <select name="category_id" id="" class="form-control select2" data-placeholder="Chọn dịch vụ">
                                    <option></option>
                                    @if(count($categories))
                                        @foreach($categories as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-2">
                                <select name="branch_id" id="" class="form-control select2" data-placeholder="Chọn chi nhánh">
                                    <option></option>
                                    @if(count($branch_ids))
                                        @foreach($branch_ids as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-2">
                                <input name="searchName" type="text" class="form-control" placeholder="Tên source">
                            </div>
                            <button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <div class="card-content collapse show">
                <div class="card-body">
                    @include('marketing.source_landipage.ajax')
                    @include('marketing.source_landipage.modal')
                </div>
            </div>
        </div>
        <!-- // card-actions section end -->

        <!-- // Modal Landi-->
        <div class="modal fade text-left" id="modalLandipage" tabindex="-1" role="dialog"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 90%;">
                <div class="modal-content">
                    <div class="modal-header bg-main">
                        <h3 class="modal-title"> SINH MÃ NHÚNG SOURCE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="pu-caption">
                                    <div class="row mb-1">
                                        <div class="col-6">
                                            <span class="label fz-12 required">Website ladipage:</span>
                                            <a target="_blank" class="text-lowercase" href="https://builder.ladipage.com/landing-pages">
                                                https://builder.ladipage.com/landing-pages
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <span class="label fz-12 required">Url API </span>
                                            <input type="text" class="form-control square h30 form_html" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <img style="width:95%" src="/default/landing-popup.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- // END Modal Landi-->

@endsection
@section('_script')
    <script>
        
        $(document).on('click','.searchData',function () {

        })

        $(document).on('click','.add_new',function (e) {
            e.preventDefault();
            resetValueForm();
            $('#modalSourceFB').modal('show');

        })


        $(document).on('click', '.edit', function () {
            let item = $(this).data('item');
            let form = $('#validateForm');
            form.attr('action', '/marketing/source-landipage/' + item.id);
            form.attr('method', 'POST');
            $('#myModalLabel').html('Cập nhật nguồn').change();
            $('#validateForm').append('<input name="_method" class="_method" type="hidden" value="PUT" />');
            $('#name').val(item.name);
            $('.url_source').val(item.url_source);
            $('.category_id').val(JSON.parse(item.category_id)).change();
            $('.sale_id').val(JSON.parse(item.sale_id)).change();
            $('.branch_id').val(JSON.parse(item.branch_id)).change();
            $('.chanel-source').val(item.chanel).change();
            $('#modalSourceFB').modal('show');
        })

        function resetValueForm(){
            let form = $('#validateForm');
            let acction = '/marketing/source-landipage';
            form.attr('action', acction);
            $('._method').remove();
            $('#modalSourceFB .name').val('').change();
            $('#modalSourceFB .url_source').val('').change();
            $('#modalSourceFB .sale_id').val('').change();
        }

        $(document).on('click','.onAccept',function () {
            let value = $(this).is(':checked');
            let id = $(this).data('id');
            let data = {
                id: id,
                value: value
            };
            $.ajax({
                url:'/marketing/update-accept-source-landi',
                method:'post',
                data:data,
                success:function (data) {
                    if(data && data.statusCode == true){
                        if(value == true){
                            alertify.success('Duyệt thành công !');
                        } else {
                            alertify.success('Hủy duyệt thành công !');
                        }
                    }else {
                        alertify.error('Bạn không có quyền duyệt !');
                    }
                }
            })
            // axios.post('/ajax/marketing/update-accept-source',
            //     data)
            //     .then(res => {
            //         if (res.data.statusCode == 200) {
            //             if(value == true){
            //                 alertify.success('Duyệt thành công !');
            //             } else {
            //                 alertify.success('Hủy duyệt thành công !');
            //             }
            //         } else {
            //             alertify.error('Bạn không có quyền !');
            //         }
            //     })
            //     .catch(err => {
            //         console.log('error', err)
            //     })
        })
        
        $(document).on('click','.settingSource',function () {
            $('.form_html').val($(this).data('url'));
            $('#modalLandipage').modal('show');
        })
    </script>
@endsection
