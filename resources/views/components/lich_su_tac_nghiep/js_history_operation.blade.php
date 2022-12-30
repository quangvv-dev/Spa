<script>
    $(document).on('click','.show-modal-history',function () {
        let customer_id = $(this).data('item');

        $('.list-history').html("");
        $('.list-operation').html("");
        $.ajax({
            url:'/ajax/customer/history-status',
            data:{
                customer_id: customer_id
            },
            success: function (data) {
                if(data.history_new.length > 0 ){
                    let html = "";
                    data.history_new.forEach(function (item,index) {
                        let name = item.status_old != null ? item.status_old.name : '';
                        let name_new = item.status_new != null ? item.status_new.name : '';
                        let stt = index + 1
                        html += `
                                <tr>
                                    <td>`+stt+`</td>
                                    <td>`+name+`</td>
                                    <td>`+name_new+`</td>
                                    <td>`+item.note+`</td>
                                    <td>`+item.user.full_name+` <br> `+item.created_at+`</td>
                                </tr>
                            `
                    })
                    $('.list-history').html(html)
                }
                if(data.arr_customer.length > 0){
                    let html_row = "";
                    data.arr_customer.forEach(function (value) {
                        html_row += `
                            <div class="col-12"><a href="#" class="pointer clickOperation" data-id=`+value.id+`>`+value.name+` (`+value.phone+`)</a></div>
                            <div class="col-12 operation-`+value.id+`"></div>
                        `
                    })
                    $('.list-operation').html(html_row)
                }

            }

        })
        $('#modalHistory').modal('show');
    })

    $(document).on('click','.clickOperation',function () {
        let customer_id = $(this).data('id');
        let class_row = ".operation-"+customer_id;
        let list_history = "list-history-"+customer_id;
        let row_list_history = ".list-history-"+customer_id;

        $(class_row).html(`
            <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Trạng thái cũ</th>
                <th>Trạng thái mới</th>
                <th>Ghi chú</th>
                <th>Thời gian</th>
            </thead>
            <tbody class="`+list_history+`"></tbody>
            </table>
        `)

        $.ajax({
            url:'/ajax/customer/history-status',
            data:{
                customer_id: customer_id
            },
            success: function (data) {
                if(data.history_new.length > 0 ){
                    let html = "";
                    data.history_new.forEach(function (item,index) {
                        let name = item.status_old != null ? item.status_old.name : '';
                        let name_new = item.status_new != null ? item.status_new.name : '';
                        let stt = index + 1
                        html += `
                                <tr>
                                    <td>`+stt+`</td>
                                    <td>`+name+`</td>
                                    <td>`+name_new+`</td>
                                    <td>`+item.note+`</td>
                                    <td>`+item.user.full_name+` (`+item.user.username+`) <br> `+item.created_at+`</td>
                                </tr>
                            `
                    })
                    $(row_list_history).html(html)
                }
            }
        })
    })
</script>
