<template>
    <div class="chat-application">
        <div class="sidebar-left sidebar-fixed">
            <div class="sidebar">
                <div class="sidebar-content card d-none d-lg-block">
                    <div class="card-body chat-fixed-search">
                        <fieldset class="form-group position-relative has-icon-left m-0">
                            <input type="text" class="form-control" id="" v-model="textSearch"
                                   placeholder="Tên người dùng" @keyup="searchTimeOut()">
                            <div class="form-control-position">
                                <i class="ft-search"></i>
                            </div>
                        </fieldset>
                    </div>
                    <div id="users-list" class="list-group position-relative">
                        <div class="users-list-padding media-list">
                            <a class="media border-0"
                               :class="{'bg-blue-grey bg-lighten-5':classClick == item.participants.data[0].id}"
                               v-for="(item,index) in navChat"
                               @click="selectMessage(item)"
                               :key="index">
                                <div class="media-left pr-1">
                                      <span class="avatar avatar-md avatar-online">
                                        <img class="media-object rounded-circle"
                                             :src="`https://graph.facebook.com/${item.participants.data[0].id}/picture?type=normal&access_token=${item.access_token}`"
                                             alt="Generic placeholder image">
                                      </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading" :class="{bold:item.new_message}">
                                        {{item.participants.data[0].name}}
                                        <span
                                                class="font-small-3 float-right primary">{{date(item.updated_time)}}</span>
                                    </h6>
                                    <p class="list-group-item-text text-chat-q mb-0" :class="{bold:item.new_message}">
                                        <i class="ft-check primary font-small-2"></i> {{item.snippet.length>27 &
                                        item.unread_count ?item.snippet.substring(0,20) +
                                        '...':(item.snippet.length>27?item.snippet.substring(0,24) +
                                        '...':item.snippet)}}
                                        <span class="float-right primary">
                                            <i class="fa fa-phone text-danger" v-if="item.check_phone"></i>

                                            <i class="font-medium-1 icon-volume-off blue-grey lighten-3 mr-1"></i>
                                          <span class="badge badge-pill badge-warning">{{item.unread_count?item.unread_count:''}}</span>
                                        </span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper">
                <!--<div class="content-header row">-->
                <!--</div>-->
                <div class="content-body">
                    <div class="info-customer align-items-center" v-if="chat_current_name != ''">
                        <div class="avatar-customer d-flex align-items-center">
                                <span class="avatar avatar-md avatar-online mr-1">
                                    <img alt="avatar" :src="`https://graph.facebook.com/${fb_me}/picture?type=normal&access_token=${access_token}`"/>
                                </span>
                            <span class="name bold">{{chat_current_name}} ({{chat_current_page}})</span>
                        </div>
                    </div>
                    <section class="chat-app-window">
                        <!--<div class="badge badge-default mb-1">Chat History</div>-->
                        <div class="chats" v-for="(item,index) in emotions">
                            <div class="chat" v-if="item.from.id != fb_me">
                                <div class="chat-body">
                                    <div class="chat-content" v-if="item.display==1">
                                        <img v-if="item.file =='image'" width="320" height="180" :src="item.url" alt="">
                                        <video v-else-if="item.file =='video'" width="320" height="180" controls
                                               :src="item.url"></video>
                                        <p v-else v-html="item.message"></p>
                                    </div>
                                    <div class="chat-content" v-else style="margin-bottom: 0">
                                        <img v-if="item.file =='image'" width="320" height="180" :src="item.url" alt="">
                                        <video v-else-if="item.file =='video'" width="320" height="180" controls
                                               :src="item.url"></video>
                                        <p v-else v-html="item.message"></p>
                                    </div>
                                </div>

                            </div>
                            <div class="chat chat-left" v-else>
                                <div class="chat-avatar" v-if="item.display==1">
                                    <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title=""
                                       data-original-title="">
                                        <img alt="avatar"
                                             :src="`https://graph.facebook.com/${item.from.id}/picture?type=normal&access_token=${access_token}`"/>
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content" v-if="item.display==1">
                                        <img v-if="item.file =='image'" width="320" height="180" :src="item.url" alt="">
                                        <video v-else-if="item.file =='video'" width="320" height="180" controls
                                               :src="item.url"></video>
                                        <p v-else v-html="item.message"></p>
                                    </div>
                                    <div class="chat-content" v-else style="margin-bottom: 0">
                                        <img v-if="item.file =='image'" width="320" height="180" :src="item.url" alt="">
                                        <video v-else-if="item.file =='video'" width="320" height="180" controls
                                               :src="item.url"></video>
                                        <p v-else v-html="item.message"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--<p class="time">1 hours ago</p>-->
                    </section>
                    <div class="">
                        <popover name="foo" class="ngon-ngay">
                            <div class="ant-popover-inner">
                                <div>
                                    <div class="ant-popover-title">
                                        <div class="set_font_family pop-qr-title">
                                            <span class="mr-1">Mẫu trả lời nhanh</span>
                                            <div class="edit-btn" style="align-self: center">
                                                <a :href="`/marketing/setting-quick-reply/${last_segment}`">
                                                    <i class="fa fa-edit pointer"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ant-popover-inner-content">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex align-items-center list-group-item-dark">
                                                <div class="tbl-space" style="width: 38px;"></div>
                                                <div class="tbl-qr-desc" style="display: block; width: 86px;">Ký tự
                                                    tắt
                                                </div>
                                                <div class="tbl-space" style="width: 62px;"></div>
                                                <div class="tbl-qr-desc">Tin nhắn</div>
                                                <div class=""></div>
                                            </li>
                                            <li class="list-group-item d-flex align-items-center list-group-item-action pointer"
                                                v-for="(item,key) in dataQuickReply"
                                                @click="selectElement(item)"
                                            >
                                                <div style="width: 38px;">{{key+1}}.</div>
                                                <div style="display: block; width: 86px;">{{item.shortcut}}</div>
                                                <div class="tbl-space" style="width: 62px;"></div>
                                                <div class="">{{item.message.substring(0,50)}} ...</div>
                                                <span class="icon-svg">
                                                    <i class="fa fa-angle-double-right"></i>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </popover>
                        <div class="modal fade text-left" id="add_new_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
                             style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document" style="max-width: 90%">
                                <div class="modal-content" style="min-height: 550px;">
                                    <div class="upload-multiple-image" style="margin: 0 auto;">
                                        <vue-upload-multiple-image
                                                @upload-success="uploadImageSuccess"
                                                @before-remove="beforeRemove"
                                                @edit-image="editImage"
                                                @data-change="dataChange"
                                                :dataImages="images"
                                                idUpload="myIdUpload"
                                                editUpload="myIdEdit"
                                                :showEdit=false
                                                :multiple=true
                                        ></vue-upload-multiple-image>
                                    </div>
                                    <!--<div class="modal-footer">-->
                                    <!--<button class="btn btn-primary" ><i class="fa fa-plus"></i> Lưu</button>-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="chat-app-form">
                        <div class="chat-app-input d-flex">
                            <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                                <div class="form-control-position">
                                    <i class="icon-emoticon-smile"></i>
                                </div>
                                <input v-on:keyup.enter="onEnter" type="text" class="form-control" id="iconLeft4" placeholder="Type your message"
                                       v-model="contentMesage">
                                <div class="form-control-position control-position-right" v-if="this.last_segment">
                                    <!--<i class="ft-image" v-popover.top="{ name: 'images'}"></i>-->
                                    <span class="openForm">
                                        <i class="fa fa-file-image" @click="openForm()"></i>
                                        <span class="badge badge-success" v-if="data_images_upload_server.length >0">
                                            <span class="ngonngay">{{data_images_upload_server.length}}</span>
                                            <span class="ngonngay1" @click="clearImage" style="display: none">x</span>
                                        </span>
                                    </span>
                                    <i class="fa fa-mail-bulk openPopover" v-popover.top="{ name: 'foo'}"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                                <button type="button" class="btn btn-primary" @click="sendMessage(contentMesage)"><i
                                        class="fa fa-paper-plane-o d-lg-none"></i>
                                    <span class="d-none d-lg-block">Send</span>
                                </button>
                            </fieldset>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import VueUploadMultipleImage from 'vue-upload-multiple-image'
    import axios from 'axios'
    import io from 'socket.io-client';
    import moment from 'moment';

    // var host = 'https://crm.santa.name.vn:2022/';
    var port = 2022;
    var host = 'https://' + location.host + ':'+port;

    var socket = io.connect(host, {transports: ['websocket', 'polling', 'flashsocket']});

    export default {
        data() {
            return {
                textSearch: '',
                contentMesage: '',
                navChat: [],
                navChatDefault: [],
                fb_me: '',
                before: 9,
                access_token: '',
                detailMessage: [],
                last_segment: '',
                avatar_page: '/default/logo.png',
                classClick: '',
                arr_page_id: [],

                dataQuickReply: [],
                images:[],
                data_images_upload_server:[],
                data_images_upload_server_default:[],
                chat_current_name : '',
                chat_current_page : ''
            }
        },
        components: {
            VueUploadMultipleImage
        },

        created() {
            this.getListChat();
        },
        computed: {
            emotions() {
                return this.detailMessage.map((value, key) => {
                    if (value.from.id != this.last_segment) {
                        if (key == 0) {
                            this.before = value.from.id;
                        }
                        if (key > 1 && this.before == value.from.id) {
                            value.display = 0;
                        } else {
                            this.before = value.from.id;
                            value.display = 1;
                        }
                    } else {
                        this.before = value.from.id;
                        value.display = 1;
                    }
                    if (value.attachments && value.attachments.data[0].image_data) {
                        value.url = value.attachments.data[0].image_data.url;
                        value.file = 'image';
                    } else if (value.attachments && value.attachments.data[0].video_data) {
                        value.url = value.attachments.data[0].video_data.url;
                        value.file = 'video';
                    }

                    return value
                });
            }
        },
        mounted() {
            console.log(33333,this.arr_page_id);
            this.arr_page_id.forEach(item=>{
                socket.on(item.id, (server) => {
                    let newTime = moment().format('YYYY-MM-DDTHH:mm:ssZZ');
                    if(server.type){
                        console.log(121212,server);
                    } else {
                        console.log(232323,server);
                        let html = {
                            message: server.message.text,
                            from: {
                                id: server.sender.id,
                            }
                        };
                        console.log(server.sender.id, server.recipient.id, newTime, 1, server.message.text, 'Active Devices'); // x8WIv7-mJelg7on_ALbx

                        this.customerNewMessage(server.sender.id, server.recipient.id, newTime, 1, server.message.text, server.message.mid);
                        if (this.classClick == server.sender.id) {
                            if (!server.message.text) {
                                let url = server.message.attachments[0].payload.url;
                                if (server.message.attachments[0].type == 'image') {
                                    // html.attachments.data[0].image_data.url = url
                                    html = {
                                        message: server.message.text,
                                        from: {
                                            id: server.sender.id,
                                        },
                                        attachments: {
                                            data: [
                                                {
                                                    image_data: {
                                                        url: url
                                                    }
                                                }
                                            ]
                                        }
                                    };
                                } else if (server.message.attachments[0].type == 'video') {
                                    html = {
                                        message: server.message.text,
                                        from: {
                                            id: server.sender.id,
                                        },
                                        attachments: {
                                            data: [
                                                {
                                                    video_data: {
                                                        url: url
                                                    }
                                                }
                                            ]
                                        }
                                    };
                                }
                            }
                            this.detailMessage.push(html);
                        }

                    }

                    // console.log(server, 'Active Devices'); // x8WIv7-mJelg7on_ALbx
                });

            })

        },
        methods: {
            onEnter: function () {
                this.sendMessage(this.contentMesage);
            },
            scrollToBottom: function () {
                setTimeout(function () {
                    document.getElementById('app');
                    const container = this.$el.querySelector(".chat-app-window");
                    container.scrollTop = container.scrollHeight;
                }.bind(this), 1500)
            },
            date: function (date) {
                return moment(date).format('D-M-YY h:mm');
            },

            searchTimeOut() {
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    this.navChat = this.navChatDefault.filter(item => {
                        let re = new RegExp(`${this.textSearch}`, 'gi');
                        return item.participants.data[0].name.match(re);
                    });
                }, 800);
            },

            async sendMessage(model) {
                let rq = axios.post(`https://graph.facebook.com/v10.0/me/messages?access_token=${this.access_token}`, {
                    // "messaging_type": "MESSAGE_TAG",
                    // "tag": "HUMAN_AGENT",
                    "messaging_type": "RESPONSE",
                    "notification_type": "REGULAR",
                    "recipient": {
                        "id": this.fb_me
                    },
                    "message": {
                        "text": model
                    }
                })
                let html = {
                    message: this.contentMesage,
                    from: {
                        id: this.last_segment,
                    }
                };
                this.detailMessage.push(html);

                let data_image_response = [];
                await axios.post('/marketing/setting-quick-reply/test', this.data_images_upload_server).then(response => {
                    // this.detailMessage = response.data.messages.data.reverse();
                    data_image_response = response.data;
                });
                if(data_image_response.length > 0){
                    data_image_response.forEach(async f =>{
                        await axios.post(`https://graph.facebook.com/v10.0/me/messages?access_token=${this.access_token}`, {
                            "messaging_type": "RESPONSE",
                            "notification_type": "REGULAR",
                            "recipient": {
                                "id": this.fb_me
                            },
                            "message": {
                                attachment:{"type":"image",
                                    "payload":{
                                        "is_reusable": true,
                                        "url":location.origin+'/'+f
                                    }
                                }
                            }
                        }).then(res=>{
                            html = {
                                display: 1,
                                file:"image",
                                from: {
                                    id: this.last_segment,
                                },
                                url: location.origin+'/'+f
                            }
                            this.detailMessage.push(html);
                        })

                    })

                    axios.post('/marketing/setting-quick-reply/delete-image', data_image_response).then(response => {
                        this.images = [];
                    })
                }

                this.contentMesage = '';
            },

             async getListChat() {
                let arr_page_id = this.$cookies.get('arr_page_id');
                let arr = [];
                if(arr_page_id){
                    arr_page_id = JSON.parse(arr_page_id);
                    // this.arr_page_id = arr_page_id;

                    for (const item of arr_page_id){
                        let access_token = item.token;
                        let fields = 'updated_time,name,id,participants,snippet';
                        let url = 'https://graph.facebook.com/v13.0/me/conversations?fields=' + fields + '&access_token=' + access_token;

                        try {
                            const res = await axios.get(url);
                            let data = res.data.data;
                            data = data.map((m)=>{
                                m.access_token = item.token;
                                return m;
                            })
                            arr.push(...data);
                        } catch (e) {
                            arr_page_id = arr_page_id.filter(f=>{return f.id != item.id})
                            alertify.error(`Token hết hạn: ${item.id}`,60000)
                        }

                    }
                    this.arr_page_id = arr_page_id;
                    console.log(5555,this.arr_page_id);
                }
                 arr = arr.filter(f => {
                     return f.participants.data[0].id != '3873174272720720';
                 });
                 this.navChat = arr;
                 this.navChatDefault = arr;
                 this.getPhonePage();
            },

            getPhonePage(){
                let arr_page = this.arr_page_id.map(m=> m.id);
                axios.get('/marketing/get-phone-page',{
                    params:{
                        arr_page: arr_page
                    }
                }).then(response => {
                    let abc = this.navChat.map(m=>{
                        let bcd = response.data.filter(f=>{return(f.page_id == m.participants.data[1].id && f.FB_ID == m.participants.data[0].id)})
                        if(bcd.length > 0){
                            m.check_phone = 1;
                        } else {
                            m.check_phone = 0;
                        }
                        return m;
                    })
                    this.navChat = abc;
                    this.navChatDefault = abc;
                })
            },

            selectMessage(item) {
                let id = item.id;
                let fb_id = item.participants.data[0].id;
                let access_token = item.access_token;
                let page_id = item.participants.data[1].id;
                this.last_segment = page_id;

                let fields = 'messages{created_time,message,attachments{image_data,video_data},from}';
                let url = `https://graph.facebook.com/v10.0/${id}/?fields=${fields}&access_token=${access_token}`;
                axios.get(url)
                    .then(response => {
                        this.detailMessage = response.data.messages.data.reverse();
                        console.log(this.detailMessage);
                    })
                this.classClick = fb_id;
                this.fb_me = fb_id;
                this.access_token = access_token;

                const index = this.navChatDefault.findIndex(f => f.id === id);
                this.navChatDefault[index].unread_count = 0;
                this.navChatDefault[index].new_message = false;
                this.chat_current_name = item.participants.data[0].name;
                this.chat_current_page = item.participants.data[1].name;
                this.getListQuickReply();
                this.scrollToBottom();
            },
            selectElement(item){
                this.contentMesage = item.message;
            },
            getListQuickReply(){
                axios.get(`/api/get-quick-reply/${this.last_segment}`).then(response => {
                    if(response.data){
                        this.dataQuickReply = response.data.data;
                    }
                })
            },

            customerNewMessage(sender_id, page_id, created_time, unread_count, mess, mid) {
                let customer_new = this.navChatDefault.filter(f => {
                    return f.participants.data[0].id == sender_id && f.participants.data[1].id == page_id;
                });

                let customer_new_mess = {};
                if (customer_new.length > 0) {
                    customer_new_mess = customer_new[0];
                    customer_new_mess.unread_count = customer_new_mess.unread_count && customer_new_mess.unread_count > 0 ? unread_count + customer_new[0].unread_count : unread_count;
                } else {
                    let token = this.arr_page_id.filter(f=> {return f.id == page_id});

                    let access_token = token.token;

                    let fields = 'id,created_time,message,thread_id,attachments,from';
                    let url = `https://graph.facebook.com/v10.0/${mid}/?fields=${fields}&access_token=${access_token}`;
                    axios.get(url).then(response => {
                        customer_new_mess.id = response.thread_id;
                        customer_new_mess.participants = {
                            data: [
                                {
                                    id: sender_id,
                                    name: response.from.name,
                                },
                                {
                                    id: page_id
                                }
                            ]
                        }
                    })
                    customer_new_mess.unread_count = unread_count;
                }
                customer_new_mess.updated_time = created_time;
                customer_new_mess.snippet = mess ? mess : customer_new_mess.participants.data[0].name +" đã gửi đa phương tiện...";
                customer_new_mess.new_message = true;

                let index = this.navChatDefault.findIndex(f=> {
                    return (f.participants.data[0].id == sender_id && f.participants.data[1].id == page_id);
                })

                if (index > -1) {
                    this.navChatDefault.splice(index, 1); // 2nd parameter means remove one item only
                }

                this.navChatDefault.unshift(customer_new_mess);
                this.navChat = this.navChatDefault;
            },

            openForm(){
                $('#add_new_form').modal({show: true})
            },
            uploadImageSuccess(formData, index, fileList) {
                this.data_images_upload_server = fileList;
            },
            beforeRemove (index, done, fileList) {
                var r = confirm("remove image")
                if (r == true) {
                    done()
                } else {
                }
            },
            editImage (formData, index, fileList) {

            },
            dataChange (){

            },
            clearImage(){
                this.data_images_upload_server = [];
                this.images = [];
            }

        }

    }
</script>
<style scoped>

    .chat-application .avatar img {
        max-height: 50px !important;
    }

    .text-chat-q {
        color: #97a2b7
    }

    .ant-popover-inner {
        background-color: #fff;
        background-clip: padding-box;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 15%);
    }

    .ant-popover-inner .ant-popover-title {
        min-width: 177px;
        min-height: 32px;
        margin: 0;
        color: rgba(0, 0, 0, .85);
        font-weight: 500;

        padding: 5px 12px;
        height: 32px;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: end;
        justify-content: flex-end;
        border-bottom: 1px solid #D9D9D9;
    }

    .set_font_family {
        font-family: 'Roboto', Helvetica, Arial, sans-serif !important;
    }

    .ant-popover-inner .ant-popover-title .pop-qr-title {
        display: flex;
        -webkit-box-pack: end;
        justify-content: flex-end;
        font-weight: bold;
        font-size: 14px;
        line-height: 22px;
        color: rgba(38, 60, 143, 0.93);
    }

    .ngon-ngay .icon-svg {
        position: absolute;
        right: 10px;
    }

    .ngon-ngay .list-group-item {
        padding: 5px 5px !important;
    }

    .ngon-ngay {
        right: 0;
        min-width: 544px;
        min-height: 450px;
        left: auto !important;
        top: auto !important;
        bottom: 14%;
    }

    .info-customer{
        padding: 10px 22px;
    }
    .chat-application .chat-app-window{
        height:calc(100% - 139px);
    }
    .ant-popover-inner-content{
        overflow-y:scroll ;
    }
    body{
        overflow: hidden !important;
    }

    .openForm{
        position: relative;
        font-size:20px;
        margin-right: 10px;
    }
    .openPopover{
        font-size:20px;
    }
    .openForm .badge{
        position: absolute;
        font-size: 10px;
        top: -7px;
        right: -7px;
    }
    .openForm .badge:hover .ngonngay {
        display: none;
    }
    .openForm .badge:hover .ngonngay1 {
        display: block !important;
    }

    .openForm .badge:not(:hover) .ngonngay{
        display: block !important;
    }
    .openForm .badge:not(:hover) .ngonngay1{
        display: none !important;
    }

    .openForm .badge span {
        position: relative;
        bottom: 2px;
        padding: 0 2px;
    }

</style>
