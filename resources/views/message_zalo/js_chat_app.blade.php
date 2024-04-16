<script>
    async function getMessage(phone) {
        let url = 'https://tapdoangtg.vn/zalo/conversation/list?phone='+phone;
        let html = '';

        try {
            const res = await $.ajax({
                url: url,
            });
            if(!res.data.length){
                alertify.warning('Không có đoạn hội thoại !');
                return false;
            }
            let convertion_id = res.data[0].id;
            let avatar = res.data[0].avatar;

            let data = await detailConvertionZalo(convertion_id);

            if (data && data.length > 0) {
                data.forEach( function (item) {
                    let convertedTime =  convertTimestamp(parseInt(item.ts));
                    let content = '';
                    if(item.msgType =="chat.photo"){
                        let object = JSON.parse(item.content);
                         content = `<img src="${object.href}" width="50p" height="50">`;
                    }else {
                         content = `<p>${item.content}</p>`;
                    }
                    if (item.id.idTo == 0) { //khách
                        html += `
                            <div class="media media-chat">
                              <img class="avatar" src="${avatar}" alt="...">
                              <div class="media-body">
                                ${content}
                                <p class="meta">
                                  <time datetime="2018">${convertedTime}</time>
                                </p>
                              </div>
                            </div>
                          `;
                    } else {
                        html += `
            <div class="media media-chat media-chat-reverse">
              <div class="media-body">
                 ${content}
              </div>
            </div>
          `;}
                });

                html = `
        <div class="ps-container ps-theme-default ps-active-y"
          style="overflow-y: scroll !important; height:400px !important;">
          ${html}
        </div>
      `;

                $('.chatContent').html(html);
            }
        } catch (error) {
            console.log(error);
        }
    }

    async function detailConvertionZalo(convertion_id) {
        let url = 'https://tapdoangtg.vn/zalo/conversation/detail/' + convertion_id;

        try {
            const res = await $.ajax({
                url: url,
            });

            return res.data.reverse();
        } catch (error) {
            console.log(error);
            return [];
        }
    }
    function convertTimestamp(timestamp){
        let date = new Date(timestamp);
        let year = date.getFullYear();
        let month = ("0" + (date.getMonth() + 1)).slice(-2);
        let day = ("0" + date.getDate()).slice(-2);
        let hours = ("0" + date.getHours()).slice(-2);
        let minutes = ("0" + date.getMinutes()).slice(-2);
        let seconds = ("0" + date.getSeconds()).slice(-2);
        return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
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
