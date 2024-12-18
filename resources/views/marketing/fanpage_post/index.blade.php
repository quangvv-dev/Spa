@extends('layout.app')
@section('content')
        <!-- card actions section start -->
        <div class="card">
            <form action="{{url()->current()}}" method="get" id="gridForm">
                <div class="card-header fix-header bottom-card add-paginate">
                    <div class="row" style="align-items: baseline">
                        <h4 class="col-lg-3">2.5 Danh sách bài post FB</h4>
                        <div class="col-lg-3 col-md-6">
                            <select name="searchUseSource" id="" class="form-control square select2"
                                    data-placeholder="--tất cả--">
                                <option></option>
                                <option value="1">Đã gắn source</option>
                                <option value="2">Chưa gắn source</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <input type="text" name="searchCustom" class="form-control square"
                                       placeholder="Tìm PageID, PostID, Nội dung">
                            </div>
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
                    <form>
                        @include('marketing.fanpage_post.ajax')
                    </form>
                    @include('marketing.fanpage_post.modal')
                </div>
            </div>
        </div>
        <!-- // card-actions section end -->

@endsection
@section('_script')
    <script>
        $(document).on('click', '.save', function () {
            showLoading();
            let id = $(this).data('id');
            let used = $(this).closest('tr').find('.used').is(":checked");
            let source_id = $(this).closest('tr').find('.source').val();
            if (!source_id) {
                hideLoading();
                alertify.warning('Source không được bỏ trống !');
                return;
            }
            $.ajax({
                url: '/marketing/fanpage-post/' + id,
                type: 'PUT',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    used: used ? 1 : 0,
                    source_id: source_id
                },
                success: function (req) {
                    hideLoading();
                    if(req){
                        alertify.success('Cập nhật thành công !');
                    } else {
                        alertify.error('Cập nhật thất bại !');
                    }
                }
            })
        })
    </script>
@endsection
