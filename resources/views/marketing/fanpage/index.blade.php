@extends('layout.app')
@section('content')
    <style>
        .profile-username a {
            color: #3c8dbc;
            font-weight: 500;
            font-family: "Roboto Condensed";
        }

        a.btn-block.btn-social {
            font-size: 14px;
            color: #fff;
            line-height: 1;
            background-color: #dd4b39 !important;
        }

        .fa.fa-facebook {
            font-size: 22px;
        }

        .pu-caption {
            font-size: 14px;
            font-weight: 600;
            font-family: "Roboto Condensed";
            color: #fc6d2e;
            text-transform: uppercase;
            padding: 10px 22px 6px 10px;
            border-bottom: 2px solid #ff8f5d;
            margin-bottom: 15px;
        }
        @media (min-width: 1280px){
            .container {
                max-width: 96%;
            }
        }

        tr td {
            padding: 0.75rem !important;
        }
        /*.tooltip-nav .tooltiptext {*/
             /*top: 0;*/
             /*left: 0;*/
        /*}*/

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-2 ml-0" style="padding-left: 30px;padding-right: 0px;">
                    @include('marketing.fanpage.profile')
                </div>
                <div class="col-10">
                    <div class="card">
                        <form action="{{url()->current()}}" method="get" id="gridForm">
                            <div class="card-header fix-header bottom-card add-paginate">
                                <div class="row" style="align-items: baseline">
                                    <h4 class="col-12 pu-caption">2.3 FANPAGE</h4>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="text" class="form-control square" name="searchPageId" placeholder="Tìm PageID">
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="text" class="form-control square" name="searchName" placeholder="Tìm Tên Fanpage">
                                    </div>
                                    <button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>
                                </div>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('marketing.fanpage.ajax')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('marketing.fanpage.modal')
        </div>
    </div>
    <div class="content-body">
        <!-- card actions section start -->
        <section id="card-actions">

        </section>
    </div>
@endsection
@section('_script')
    <script>
        var page_id = '';
        var source_id = '';
        var access_token = '';
        $(document).on('click', '.save', function () {
            showLoading();
            let id = $(this).data('id');
            let access_token = $(this).data('token');
            let page_id = $(this).attr('data-fanpageId');
            let fields = 'feed,messages,conversations,inbox_labels';
            let used = $(this).closest('tr').find('.used').is(":checked");
            let auto_create_source = $(this).closest('tr').find('.auto_create_source').is(":checked");
            let use_source = $(this).closest('tr').find('.use_source').is(":checked");
            let source_id = $(this).closest('tr').find('.source').val();
            let self = this;

            if(!used){
                $.ajax({
                    url: 'https://graph.facebook.com/v13.0/' + page_id + '/subscribed_apps?&access_token='+ access_token,
                    type: 'DELETE',
                    success: function (req) {
                        hideLoading();
                        alertify.success('Huỷ đăng ký nhận thông báo facebook thành công !');
                        if (req) {
                            $(self).closest('tr').find('td .retweet').attr("data-show", "true");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        hideLoading();
                        alertify.warning('chưa đăng ký nhận thông báo facebook !');
                    }
                })
            }

            if(!source_id){
                hideLoading();
                alertify.warning('Source không được bỏ trống !');
                return;
            }
            $.ajax({
                url: '/marketing/fanpage/' + id,
                type: 'PUT',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    used: used ? 1 : 0,
                    auto_create_source: auto_create_source ? 1 : 0,
                    use_source: use_source ? 1 : 0,
                    source_id: source_id
                },
                success: function (data) {
                    if (data.used == 1 && data.source_id) {
                        $.ajax({
                            url: 'https://graph.facebook.com/v13.0/' + page_id + '/subscribed_apps?subscribed_fields=' +fields +'&access_token=' + access_token,
                            type: 'POST',
                            success: function (req) {
                                hideLoading();
                                alertify.success('Cập nhật & xác thực page thành công !');
                                if (req) {
                                    $(self).closest('tr').find('td .retweet').attr("data-show", "true");
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                hideLoading();
                                alertify.error('Facebook token hết hạn, vui lòng đăng nhập lại !');
                            }
                        })
                    } else {
                        $(self).closest('tr').find('td .retweet').attr("data-show", "false");
                        hideLoading();
                        alertify.success('Cập nhật thành công !')
                    }
                }
            });
        })

        //button đồng bộ
        $(document).on('click', '.retweet', function () {
            source_id = $(this).closest('tr').find('.source').val();
            access_token = $(this).attr('data-token');
            page_id = $(this).attr('data-fanpageId');
            $('.modal-retweet').modal('show');
        })

        //submid đồng bộ
        $(document).on('click', '.btn-social.btn-facebook', function () {
            showLoading();
            let total_post = $('.total_post').val();
            $.ajax({
                url: 'fanpage-post',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    total_post: total_post,
                    page_id: page_id,
                    source_id: source_id,
                    access_token: access_token
                },
                success: function (data) {
                    if(data && data === 1){
                        alertify.success('Cập nhật thành công !')
                    }
                    hideLoading();
                    $('#bootstrap').modal('hide');
                }
            })
        })
    </script>
@endsection
