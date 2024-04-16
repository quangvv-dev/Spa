<script>
    var lastTimestamp = 0;
    var prevTimestamp = 0;
    var convertion_id = 0;
    var avatar = null;
    async function getMessage(phone) {
        let url = 'https://tapdoangtg.vn/zalo/conversation/list?phone='+phone;

        try {
            const res = await $.ajax({
                url: url,
            });
            if(!res.data.length){
                alertify.warning('Không có đoạn hội thoại !');
                return false;
            }
            convertion_id = res.data[0].id;
            avatar = res.data[0].avatar;
            let data = await detailConvertionZalo(convertion_id);
            if (data && data.length > 0) {
                let html = parseMessages(data, avatar);
                $('.chatContent').html(html);
            }
        } catch (error) {
            console.log(error);
        }
    }
    function parseMessages(data, avatar) {
        let html = '';
        let content = '';
        data.forEach( function (item,key) {
            console.log(key,'KEY');
            if(key == (data.length - 1)){
                lastTimestamp = parseInt(item.ts);
            }
            if(key == 0){
                prevTimestamp = parseInt(item.ts);
            }
            let convertedTime =  convertTimestamp(parseInt(item.ts));
            if(item.msgType =="chat.photo"){
                let object = JSON.parse(item.content);
                content = `<img src="${object.href}" width="50p" height="50">`;
            }
            else if(item.msgType =="chat.ecard"){
                let object = JSON.parse(item.content);
                content = `<p>${object.title}</p>`;
            }
            else {
                if(item.content.includes("{")) {
                    return;
                }
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
        </div>`;
        return html;
    }

    async function detailConvertionZalo(convertion_id, lastTimestamp = null) {
        let url = 'https://tapdoangtg.vn/zalo/conversation/detail/' + convertion_id;

        try {
            const res = await $.ajax({
                url: url,
                data: {timestamp: lastTimestamp},
            });

            // return res.data.reverse();
            return res.data;
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

    $(document).on('click', '.chatApplication .next',async function (e) {
        e.preventDefault();
        let data = await detailConvertionZalo(convertion_id, lastTimestamp);
        if (data && data.length > 0) {
            let html = parseMessages(data, avatar);
            $('.chatContent').html(html);
        }
    })

    $(document).on('click', '.chatApplication .previous',async function (e) {
        e.preventDefault();
        let data = await detailConvertionZalo(convertion_id, prevTimestamp);
        if (data && data.length > 0) {
            let html = parseMessages(data, avatar);
            $('.chatContent').html(html);
        }
    })
</script>
