<script>
    $(document).on('click','#click_tab_14',function () {
        console.log(123131);
        let page_id = $('.chat-page_id').val();
        let sender_id = $('.chat-sender_id').val();
        let token = $('.chat-token').val();
        let url = 'https://graph.facebook.com/v10.0/'+page_id+'/conversations?fields=messages{message,from,created_time}&user_id='+sender_id+'&access_token='+token;
        let html = '';
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
    })
</script>
