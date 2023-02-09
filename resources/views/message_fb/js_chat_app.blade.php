<script>
    function getMessage(page_id,sender_id,token){
        let url = 'https://graph.facebook.com/v16.0/'+page_id+'/conversations?fields=messages{message,from,created_time}&user_id='+sender_id+'&access_token='+token;
        let html = '';
        if(page_id && sender_id && token){
            $.ajax({
                url: url,
                success: function (res) {
                    let data = res.data[0].messages.data.reverse();
                    if(data && data.length > 0){
                        data.forEach(function (item) {
                            if(item.from.id == sender_id){ //khách
                                html+= `
                                <div class="media media-chat">
                                    <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                                                   alt="...">
                                    <div class="media-body">
                                        <p>`+item.message+`</p>
                                        <p class="meta">
                                            <time datetime="2018">`+item.created_time+`</time>
                                        </p>
                                    </div>
                                </div>
                            `
                            } else {
                                html += `
                                <div class="media media-chat media-chat-reverse">
                                    <div class="media-body">
                                        <p>`+item.message+`</p>
                                    </div>
                                </div>
                            `
                            }
                        })
                        html = `
                        <div class="ps-container ps-theme-default ps-active-y"
                         style="overflow-y: scroll !important; height:400px !important;">
                        `+html+`
                        </div>
                    `
                        $('.chatContent').html(html)
                    }
                }
            })
        }
    }

    $(document).on('click', '.chatApplication .next', function (e) {
        e.preventDefault();
        let url_new = $('.chatApplication .input-next').val();
        let sender_id = $('.chat-sender_id').val();
        let html = '';
        $.ajax({
            url: url_new,
            success: function (res) {
                let data = res.data.reverse();

                if (res.paging.next) {
                    $('.chatApplication .input-next').val(res.paging.next).change();
                    $('.chatApplication .next').href = res.paging.next;
                    $('.chatApplication .next').show();
                } else {
                    $('.chatApplication .next').hide();
                }
                if (res.paging.previous) {
                    $('.chatApplication .input-previous').val(res.paging.previous).change();
                    $('.chatApplication .previous').href = res.paging.previous;
                    $('.chatApplication .previous').show();
                }
                if (data && data.length > 0) {
                    data.forEach(function (item) {
                        if (item.from.id == sender_id) { //khách
                            html += `
                                <div class="media media-chat">
                                    <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                                                   alt="...">
                                    <div class="media-body">
                                        <p>` + item.message + `</p>
                                        <p class="meta">
                                            <time datetime="2018">` + item.created_time + `</time>
                                        </p>
                                    </div>
                                </div>
                            `
                        } else {
                            html += `
                                <div class="media media-chat media-chat-reverse">
                                    <div class="media-body">
                                        <p>` + item.message + `</p>
                                    </div>
                                </div>
                            `
                        }
                    })
                    html = `
                        <div class="ps-container ps-theme-default ps-active-y"
                         style="overflow-y: scroll !important; height:400px !important;">
                        ` + html + `
                        </div>
                    `
                    $('.chatContent').html(html)
                }
            }
        })
    })

    $(document).on('click', '.chatApplication .previous', function (e) {
        e.preventDefault();
        let url_new = $('.chatApplication .input-previous').val();
        let sender_id = $('.chat-sender_id').val();
        let html = '';
        $.ajax({
            url: url_new,
            success: function (res) {
                let data = res.data.reverse();

                if (res.paging.next) {
                    $('.chatApplication .input-next').val(res.paging.next).change();
                    $('.chatApplication .next').href = res.paging.next;
                    $('.chatApplication .next').show();
                } else {
                    $('.chatApplication .next').hide();
                }
                if (res.paging.previous) {
                    $('.chatApplication .input-previous').val(res.paging.previous).change();
                    $('.chatApplication .previous').href = res.paging.previous;
                    $('.chatApplication .previous').show();
                } else {
                    $('.chatApplication .previous').hide();
                }
                if (data && data.length > 0) {
                    data.forEach(function (item) {
                        if (item.from.id == sender_id) { //khách
                            html += `
                                <div class="media media-chat">
                                    <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                                                   alt="...">
                                    <div class="media-body">
                                        <p>` + item.message + `</p>
                                        <p class="meta">
                                            <time datetime="2018">` + item.created_time + `</time>
                                        </p>
                                    </div>
                                </div>
                            `
                        } else {
                            html += `
                                <div class="media media-chat media-chat-reverse">
                                    <div class="media-body">
                                        <p>` + item.message + `</p>
                                    </div>
                                </div>
                            `
                        }
                    })
                    html = `
                        <div class="ps-container ps-theme-default ps-active-y"
                         style="overflow-y: scroll !important; height:400px !important;">
                        ` + html + `
                        </div>
                    `
                    $('.chatContent').html(html)
                }
            }
        })
    })
</script>
