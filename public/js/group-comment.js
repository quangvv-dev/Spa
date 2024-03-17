$(document).on('click', '.view_modal', function (e) {
    e.preventDefault();

    $('.customer-chat').empty();
    let id = $(this).data('customer-id');
    let check_show_button = false;
    $.ajax({
        url: "/group_comments/" + id,
        method: "get",
    }).done(function (data) {
        let category = '';

        data.customer.categories.forEach(function (item) {
            category += item.name + `, `;
        });

        let html = '';
        html += `<div class="row" style="padding-bottom: 10px;">
                    <div class="chat-flash col-md-12">
                        <div class="white-space" style="display: flex; align-items: center;justify-content: space-around;">
                            <img width="50" height="50" class="fl mr10 a40 border"
                                 src="{{asset('default/no-image.png')}}" style="border-radius:100%">

                            <div class="mt10 pb10" style="height:86px ; color:black">
                            <div class="col-md-12 info-avatar padding5 last_contacthover box_last">
                            <p><i class="fa fa-user mr5" style="color: black;"></i> ` + data.customer.full_name + `
                                <i class="fa orange fa-star" aria-hidden="true" style="color: orange;"></i>
                            </p>
                            <p class="mt10"><i class="fa fa-phone mr10" style="color: black;" aria-hidden="true"></i><a class="__clickToCall blue" data-contact-id="5678"
                                                          rel="tooltip" data-original-title="Click để gọi"
                                                          data-placement="right" data-flag="1"
                                                          data-type="crm"> ` + data.customer.phone + `</a></p>
                            <p> <i class="fa fa-users"style="color: black;" aria-hidden="true"></i>` + category + `</p>
                            <p class="mt10 white-space"><i class="icon-envelope mr5"></i></p></div>
                        </div>
                        <a class="bold blue uppercase user-name" href="javascript:void(0);" style="margin-left: 5px">
                            <span>@` + (data.customer.telesale ? data.customer.telesale.full_name : "") + `</span></br>
                            <span>Cskh: ` + (data.customer.cskh ? data.customer.cskh.full_name : "") + `</span>
                            </a>
                        </div>

                         <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }} "style="margin-top: 20px;">
                         <label class="control-label" for="status_id">Trạng thái</label>
` +
            `<select name="status_id" class="form-control status-result select2" data-id="` + data.customer.id + `" style="font-size: 14px;">`;
        data.status.forEach(function (item) {
            html += `<option value="` + item.id + `"  ` + (item.id === data.customer.status_id ? "selected" : "") + `>` + item.name + `</option>`;
        });
        html += `</select>`;
        html += `
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Nguồn khách hàng:</div> <div class="col-md-7 word-break">` + (data.customer.source_customer ? data.customer.source_customer.name : "") + `</div> </div>
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Liên hệ lần cuối:</div> <div class="col-md-7 word-break">` + (data.last_contact ? data.last_contact : "") + `</div> </div>
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Giá trị:</div> <div class="col-md-7 word-break" style="color:orange;">` + data.order_revenue + ` VND</div> </div>
                </div>
                        <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                        <textarea class="form-control message" name="messages" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success chat-save" id="chat-save" data-customer-id="">Lưu</button>

                        <button class="btn btn-warning message-chat float-right">Hội thoại FB</button>
                        <button class="btn btn-info sale-note float-right mr-1">Trao đổi</button>
                    </div>
                </div>
                <div class="chat-ajax" >

                        </div>`;

        let html1 = '';
        data.group_comments.forEach(function (item) {
            html1 += `<div class="col comment-fast" style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;">
                                <div class="no-padd col-md-12">
                                    <div class="col-md-11"><p><a href="#" class="bold blue">` + (item.full_name ?? "") + `</a>
                                        <span><i class="fa fa-clock"> ` + item.created_at + `</i></span></p>
                                    </div>` +
                (data.id_login == item.user_id ? `<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                        <a data-original-title="Xóa" rel="tooltip">
                            <i class="fas fa-trash-alt btn-delete-comment" data-id="` + item.id + `"></i>
                                        </a>
                                    </div>` : "") +
                `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px; white-space: pre-line;">` + item.messages + `
                                    </div>
                                </div>
                            </div>`;
        });

        $(".status-result").val(data.customer.status_id).change();
        $('.customer-chat').append(html);
        $('.chat-ajax').html(html1);
        $('#view_chat').modal("show");
        $('.chat-save').attr('data-customer-chat-id', data.customer.id);
        $('#view_chat .chatApplication').hide();
        if(!check_show_button){
            $('#view_chat .message-chat').hide();
            $('#view_chat .sale-note').hide();
        } else {
            $('#view_chat .message-chat').show();
            $('#view_chat .sale-note').show();
        }
    });
});
$(document).on('click', '.chat-save', function () {
    let customer_id = $(this).data('customer-chat-id');
    let messages = $('.message').val();
    $('.message').val('');

    $.ajax({
        url: "/ajax/group-comments",
        method: "post",
        data: {
            messages: messages,
            customer_id: customer_id
        }
    }).done(function (data) {
        let html = '';
        html += `<div style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;" >
                    <div class="no-padd col-md-12 comment-fast">
                    <div class="col-md-11"><p><a href="#" class="bold blue">` + data.group_comment.user.full_name + `</a>
                        <span><i class="fa fa-clock"> ` + data.group_comment.created_at + `</i></span></p>
                    </div>` +
            (data.id_login == data.group_comment.user_id ? `<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                        <a data-original-title="Xóa" rel="tooltip">
                                            <i class="fas fa-trash-alt btn-delete-comment" data-id="` + data.group_comment.id + `"></i>
                                        </a>
                                    </div>` : "") +
            `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px; white-space: pre-line;">` + data.group_comment.messages + `</div>
                    </div>
                    </div>`;

        $('.chat-ajax').prepend(html);
    });

});
$(document).on('change', '.status-result', function (e) {
    let target = $(e.target).parent();
    let status_id = $(target).find('.status-result').val();
    let id = $(this).data('id');

    $.ajax({
        url: "ajax/customers/" + id,
        method: "put",
        data: {
            status_id: status_id
        }
    }).done(function (data) {
        $(target).parent().find(".status-db").empty();
        $(target).parent().find('.status-db').html(data.status.name);
    });
});
$(document).on('click', '.btn-delete-comment', function (e) {
    let target = $(e.target).parent().parent().parent();
    let group_comment_id = $(this).data('id');

    let result = confirm("Bạn muốn xoá tin nhắn này?");
    if (result) {
        $.ajax({
            url: "/group-comments/" + group_comment_id + "/delete",
            method: "delete",
        }).done(function () {
            $(target).parent().find(".comment-fast").remove();
        });
    }
});
