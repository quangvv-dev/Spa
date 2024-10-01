<style>
    .dropdown-custom1.show .dropdown-menu-custom.show {
        display: block !important;
    }
</style>
<i style="cursor: pointer; padding: 0;"
   class="dropdown-toggle nav-link pointer"
   aria-expanded="true">
    <img src="{{asset('layout/images/Icon_hover.png')}}">
</i>

<div class="detail__pagination dropdown-menu-custom dropdown-menu dropdown-menu-right show"
     style="padding: 10px; width: 130%; display: none;border: 1px solid #3b8fec;">
    <div class="row">
        @if(isset($user_filter_list) && count($user_filter_list))
            @foreach($user_filter_list as $key => $item)
                <div class="col-3 item">
                    <label class="click-label">
                        <input {{in_array($key,$user_filter_grid) ? 'checked':''}} getDataItem type="checkbox"
                               value="{{$key}}">&nbsp;{{$item}}
                    </label>
                </div>
            @endforeach
        @endif
        <div class="col-3 item">
            <label class="click-label"><input type="checkbox" id="checkAll">&nbsp;Tất cả</label>
        </div>
    </div>
    <div class="row">
        <div class="col item">
            <button type="button" class="btn btn-primary saveFilter">Lưu lại</button>
        </div>
    </div>
    <script>
        $('.saveFilter').on('click', function () {
            let favorite = [];
            $.each($("input[getDataItem]:checked"), function () {
                favorite.push($(this).val());
            });

            $.ajax({
                url: '/ajax/user-filter-grid',
                method: 'POST',
                data: {
                    url: location.pathname,
                    fields: JSON.stringify(favorite)
                },
                success: function (data) {
                    if (data && data == 1) {
                        alertify.success('Cập nhật thành công !')
                    }
                }
            })
        })

        $(document).on('click', '#checkAll', function () {
            if (this.checked) {
                $('input:checkbox[getdataitem]').not(this).prop('checked', true);
            } else {
                $('input:checkbox[getdataitem]').not(this).prop('checked', false);
            }
        })

        $(document).on('click', '.dropdown-custom1', function (e) {
            $(this).toggleClass('show');
        })
        $(document).on('click', '.click-label', function (e) {
            e.stopEventPropagation();
        })
    </script>
</div>
