<template>
    <div class="col">
        <div class="row">
            <div class="col-9">
                <div class="pu-caption">
                    Cấu hình hiển thị
                </div>
                <!--<div class="row mb-1">-->
                <!--<div class="col-2">-->
                <!--<span class="label fz-12">Tên source</span>-->
                <!--</div>-->
                <!--<div class="col-10">-->
                <!--<input type="text" class="form-control square h30" :value="source_name">-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="row mb-1">-->
                <!--<div class="col-2">-->
                <!--<span class="label fz-12">Url source</span>-->
                <!--</div>-->
                <!--<div class="col-10">-->
                <!--<input type="text" class="form-control square h30">-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="row mb-1">-->
                <!--<div class="col-2">-->
                <!--<span class="label fz-12">Url API</span>-->
                <!--</div>-->
                <!--<div class="col-10">-->
                <!--<input type="text" class="form-control square h30">-->
                <!--</div>-->
                <!--</div>-->

                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Khung</span>
                    </div>
                    <div class="col-3">
                        <input type="color" class="form-control square h30 p-0" v-model="source.background">
                    </div>
                    <div class="col-2">
                        <span class="label fz-12">Căn lề</span>
                    </div>
                    <div class="col-1">
                        <select name="" class="form-control square h30 p-0" v-model="source.padding">
                            <option :value="item" v-for="(item,index) in size_" :key="index">{{item}}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Viền khung</span>
                    </div>
                    <div class="col-1">
                        <input type="color" class="form-control square h30 p-0" v-model="source.border_color">
                    </div>
                    <div class="col-1">
                        <select name="" class="form-control square h30 p-0" v-model="source.border_size">
                            <option :value="item" v-for="(item,index) in size_" :key="index">{{item}}</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <select name="" class="form-control square h30 p-0" v-model="source.border_style">
                            <option value="solid">solid</option>
                            <option value="dotted">dotted</option>
                            <option value="dashed">dashed</option>
                            <option value="double">double</option>
                            <option value="groove">groove</option>
                            <option value="ridge">ridge</option>
                            <option value="inset">inset</option>
                            <option value="outset">outset</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_1" class="p-0" v-model="source.is_border">
                        <label for="check_1">Có viền</label>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label required fz-12">Tiêu đề form nhúng</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.title_chinh">
                    </div>
                    <div class="col-2">
                        <span class="label fz-12">Màu tiêu đề</span>
                    </div>
                    <div class="col-1">
                        <input type="color" class="form-control square h30 p-0" v-model="source.title_chinh_color">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_2" v-model="source.is_title_chinh">
                        <label for="check_2" class="fz-12">Hiển thị</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <span class="label fz-12">Tiêu đề phụ form nhúng</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.title_phu">
                    </div>
                    <div class="col-2">
                        <span class="label fz-12">Màu tiêu đề phụ</span>
                    </div>
                    <div class="col-1">
                        <input type="color" class="form-control square h30 p-0" v-model="source.title_phu_color">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_3" v-model="source.is_title_phu">
                        <label for="check_3">Hiển thị</label>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Thông tin họ tên</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.name_form">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_4" v-model="source.is_name_form">
                        <label for="check_4">Hiển thị</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Thông tin Email</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.email_form">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_5" v-model="source.is_email_form">
                        <label for="check_5">Hiển thị</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Thông tin điện thoại</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.phone_form">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_6" v-model="source.is_phone_form">
                        <label for="check_6">Hiển thị</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Thông tin tin nhắn</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.content">
                    </div>
                    <div class="col-2">
                        <input type="checkbox" id="check_7" v-model="source.is_content">
                        <label for="check_7">Hiển thị</label>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Nút xác nhận</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.title_button">
                    </div>
                    <div class="col-2">
                        <span class="label fz-12">Màu chữ</span>
                    </div>
                    <div class="col-1">
                        <input type="color" class="form-control square h30 p-0" v-model="source.title_button_color">
                    </div>
                    <div class="col-2">
                        <span class="label fz-12">Màu nút</span>
                    </div>
                    <div class="col-1">
                        <input type="color" class="form-control square h30 p-0" v-model="source.button_color">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2">
                        <span class="label fz-12">Thông báo thành công</span>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control square h30" v-model="source.notification">
                    </div>
                </div>
                <button class="btn btn-info" @click="ngonngay"><i class="fa fa-save"></i> Lưu</button>

            </div>

            <!--Xem trước-->
            <div class="col-3">
                <div class="pu-caption">
                    Xem trước tiện ích
                </div>
                <form method="post" ref="foo" style="padding: 0px 15px">
                    <!--<input name="_token" type="hidden" value="FGHsRIgbF0xwrr6RhHkzyKyjpjysbQ8O8M57iTnb"/>-->
                    <input name="_token" type="hidden" value="U6849U5jRCHHYxfGMa8DwvpOfETAU4SAzRb690qn"/>
                    <div class="row"
                         :style="{
                                         borderWidth:source.border_size+'px',
                                         borderColor:source.border_color,
                                         borderStyle: source.is_border ? source.border_style:'',
                                         background: source.background,
                                         padding: source.padding
                                         }">
                        <div class="col-12">
                            <h2 class="text-center" v-if="source.is_title_chinh"
                                :style="{color:source.title_chinh_color}"
                                style="font-weight: 700;font-family:'Quicksand', 'sans-serif';margin: 20px 0 10px 0;">
                                {{source.title_chinh}}</h2>
                            <h2 class="text-center" v-if="source.is_title_phu" :style="{color:source.title_phu_color}"
                                style="color: #000;font-weight: 700;font-family:   'Quicksand', 'sans-serif';margin: 20px 0 10px 0;">
                                {{source.title_phu}}</h2>
                        </div>
                        <div class="col-12 mb-1">
                            <input type="text" class="form-control" name="full_name" v-if="source.is_name_form"
                                   :placeholder="source.name_form">
                            <span class="email-error"></span>
                        </div>
                        <div class="col-12 mb-1">
                            <input type="email" class="form-control" name="email" v-if="source.is_email_form"
                                   :placeholder="source.email_form">
                            <span class="email-error"></span>
                        </div>
                        <div class="col-12 mb-1">
                            <input type="text" class="form-control" name="phone" v-if="source.is_phone_form"
                                   :placeholder="source.phone_form">
                        </div>
                        <div class="col-12 mb-1 form-group">
                            <textarea rows="4" class="form-control" name="content" v-if="source.is_content"
                                      :placeholder="source.content"></textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <button type="submit" class="btn form-control border-0"
                                    :style="{color:source.title_button_color,background:source.button_color}">
                                {{source.title_button}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pu-caption">
                    <> Mã nhúng
                </div>
                <div class="row form-group">
                    <div class="col-12">
                        <label for="">Copy đoạn mã này ở vị trí mà bạn muốn hiển thị</label>
                        <input type="text" class="form-control" :value="code_nhung">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'

    const pathArray = window.location.pathname.split("/");
    export default {
        data() {
            return {
                allSale: [],
                allProduct: [],
                allMarketing: [],
                allSource: [],
                currentUser: null,

                //search
                searchUser: '',
                searchProduct: '',
                searchName: '',

                //Setting source
                size_: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40],
                source_id: pathArray[2],
                source_name: '',
                source: {
                    source: null,
                    background: '',
                    padding: 1,
                    border_color: '#ccc',
                    border_size: 1,
                    border_style: 'solid',
                    is_border: true,
                    title_chinh: 'Đăng ký mua hàng',
                    title_chinh_color: 'Đăng ký mua hàng',
                    is_title_chinh: true,
                    title_phu: '',
                    title_phu_color: '',
                    is_title_phu: true,
                    name_form: '',
                    is_name_form: true,
                    email_form: '',
                    is_email_form: true,
                    phone_form: '',
                    is_phone_form: true,
                    content: '',
                    is_content: true,
                    title_button: 'Đăng ký ngay',
                    title_button_color: '',
                    button_color: '#cccccc',
                    notification: ''
                },
                //mã nhúng
                code_nhung: '',
            }
        },
        created() {
            this.getDetail();

        },
        methods: {
            nodeToString(node) {
                var tmpNode = document.createElement("div");
                tmpNode.appendChild(node.cloneNode(true));
                var str = tmpNode.innerHTML;
                tmpNode = node = null; // prevent memory leaks in IE
                return str;
            },
            ngonngay() {
                const template = this.$refs.foo;
                let form_html = this.nodeToString(template);
                let data = {
                    form_html: form_html,
                    setting_form: JSON.stringify(this.source),
                }
                axios.put('/api/posts/' + this.source_id, data).then(res => {
                    if (res.status == 200) {
                        this.code_nhung = '<iframe src="' + location.origin + '/post/' + this.source_id + '" frameborder="0" style="width: 100%; height: 100%;"></iframe>';
                    } else {
                        swal("Có lỗi gì đó sảy ra!", "error");
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                    })

            },

            getDetail() {
                axios.get('/api/posts/' + this.source_id).then(res => {
                    if (res.status == 200) {
                        this.openFormConnect(res.data.data);
                    }
                }).catch(function (error) {
                    console.log(error);
                })
            },

            openFormConnect(source) {
                this.source_id = source.id;
                // this.source_name = source.name;
                if (source.setting_form) {
                    this.source = JSON.parse(source.setting_form);
                    this.code_nhung = '<iframe src="' + location.origin + '/post/' + source.id + '" frameborder="0" style="width: 100%; height: 100%;"></iframe>';
                }
                // $('#modalSettingSource').modal({show: true});
            },
            btnSearch() {

            },

        }

    }
</script>
<style>
    .vs__dropdown-toggle {
        border-radius: unset;
    }

    .validate #vs1__combobox {
        border-color: red;
    }

    .validate #vs2__combobox {
        border-color: red;
    }

    .validate #vs3__combobox {
        border-color: red;
    }

    .validate #vs4__combobox {
        border-color: red;
    }

    .validate input.square {
        border-color: red;
    }

    .validate label {
        color: red;
    }

    .fz-12 {
        font-size: 12px;
    }

    .h30 {
        height: 30px !important;
    }
</style>
