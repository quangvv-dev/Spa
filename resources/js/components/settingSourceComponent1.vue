<template>
    <div class="content-body">
        <!-- card actions section start -->
        <section id="card-actions">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="/marketing/source" method="get" id="gridForm">
                            <div class="card-header fix-header bottom-card">
                                <div class="row" style="align-items: baseline">
                                    <h4 class="col-lg-3">Kết nối dữ liệu</h4>
                                    <div class="col-lg-2 col-md-6">
                                        <select v-model="searchUser" id="" class="select2"
                                                data-placeholder="--Chọn marketing--">
                                            <option></option>
                                            <option v-for="(item,index) in allMarketing" :key="index" :value="item.id">
                                                {{item.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <select v-model="searchProduct" class="select2"
                                                data-placeholder="--Chọn sản phẩm--">
                                            <option></option>
                                            <option v-for="(item,index) in allProduct" :key="index" :value="item.id">
                                                {{item.product.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <fieldset class="form-group">
                                            <input type="text" class="form-control square" v-model="searchName"
                                                   placeholder="Tên source">
                                        </fieldset>
                                    </div>
                                    <button class="btn btn-primary" @click="btnSearch"><i class="fa fa-search"></i> Tìm
                                        kiếm
                                    </button>
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
                                <div class="tabs mb-1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                               role="tab" data-id="1" aria-selected="true">KẾT NỐI FACEBOOK</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                               role="tab" data-id="2" aria-selected="false">KẾT NỐI LANDIPAGE</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact"
                                               role="tab" data-id="3" aria-selected="false">KẾT NỐI WEBSITE</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#contact"
                                               role="tab" data-id="4" aria-selected="false">TẤT CẢ</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="table-responsive tableFixHead table-bordered table-hover"
                                     style="width: 100%; overflow-x: auto;">
                                    <table class="table table-custom">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 30px;">STT</th>
                                            <th class="text-center nowrap">Marketing</th>
                                            <th class="text-center">Tên nguồn kết nối <br>
                                                Url Landing
                                            </th>
                                            <th class="text-center">Loại kết nối <br>
                                                Kênh quảng cáo
                                            </th>
                                            <th class="text-center nowrap">Sản phẩm</th>
                                            <th class="text-center nowrap">Ưu tiên sale</th>
                                            <th class="text-center nowrap">Url kết nối V1</th>
                                            <th class="text-center nowrap">Duyệt</th>
                                            <th class="text-center nowrap">Cập nhật</th>
                                            <th class="text-center nowrap">
                                                <a id="add_new" @click="openFormModal()"><i class="fa fa-plus"></i> Thêm</a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in allSource.data" :key="index">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                {{item.user_id}}
                                            </td>
                                            <td class="text-center">
                                                {{item.name}}
                                            </td>
                                            <td class="text-center">
                                                {{item.type == 1 ? 'Google ads'
                                                :(item.type == 2 ? 'Facebook ads'
                                                :(item.type == 3 ? 'Zalo ads': item.type))}}
                                            </td>
                                            <td class="text-center">
                                                {{item.all_product}}
                                                <!--{{$item->getProductTextAttribute()}}-->
                                            </td>
                                            <td class="text-center">
                                                {{item.all_sale}}
                                                <!--{{$item->getUsername()}}-->
                                            </td>
                                            <td>
                                                <a href="#" class="settingSource" @click="openFormConnect(item)"><i
                                                        class="fa fa-edit"></i>
                                                    Kết nối</a>
                                            </td>
                                            <td class="text-center">
                                                <!--<input class="accept" type="checkbox" {{$item->accept == 1 ? 'checked' : ''}}>-->
                                                <input type="checkbox" @click="onAccept($event,item.id)"
                                                       :checked="item.accept">
                                            </td>
                                            <td class="text-center">
                                                123 <br>
                                                10/10/2010
                                                <!--{{@$item->user_id}} <br>-->
                                                <!--{{$item->updated_at}}-->
                                            </td>
                                            <td class="text-center">
                                                <a class="action-control" href="javascript:void(0)"
                                                   @click="openFormModal(item)">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                <a class="action-control delete" href="javascript:void(0)" data-id="1">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <!--{{$source->links()}}-->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- // Thêm mới source -->
        <div class="modal fade text-left" id="add_new_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-main">
                        <h3 class="modal-title" id="myModalLabel35"> Thêm mới source</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group" :class="{validate : is_validate && type===null}">
                            <div class="col-sm-2">
                                <label class="required">Loại kết nối</label>
                            </div>
                            <div class="col-sm-10">
                                <v-select v-model="type" :options="option_type" label="value" class="square">
                                    <template #selected-option="{value}">
                                        <div style="display: flex; align-items: baseline;">
                                            <strong>{{ value }}</strong>
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="row form-group" :class="{validate : is_validate && name===null}">
                            <div class="col-sm-2">
                                <label class="required">Tên nguồn dữ liệu</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" v-model="name" id="name" class="form-control square">
                            </div>
                        </div>
                        <div class="row form-group" :class="{validate : is_validate && url_source===null}">
                            <div class="col-sm-2">
                                <label class="required">url nguồn dữ liệu</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" v-model="url_source" id="url_source" class="form-control square">
                            </div>
                        </div>
                        <div class="row form-group" :class="{validate : is_validate && chanel===null}">
                            <div class="col-sm-2">
                                <label class="required">Kênh quảng cáo</label>
                            </div>
                            <div class="col-sm-10">
                                <v-select v-model="chanel" :options="option_chanel" label="value" class="square">
                                    <template #selected-option="{value}">
                                        <div style="display: flex; align-items: baseline;">
                                            <strong>{{ value }}</strong>
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="row form-group" :class="{validate : is_validate && product_id.length == 0}">
                            <div class="col-sm-2">
                                <label class="required">Sản phẩm</label>
                            </div>
                            <div class="col-sm-10">
                                <v-select v-model="product_id"
                                          label="product_name"
                                          :options="allProduct"
                                          multiple class="square">
                                    <template #selected-option="{ product }">
                                        <div style="display: flex; align-items: baseline;">
                                            <strong>{{ product.name }}</strong>
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="row form-group" :class="{validate : is_validate && sale_id.length == 0}">
                            <div class="col-sm-2">
                                <label class="required">Ưu tiên sale</label>
                            </div>
                            <div class="col-sm-10">
                                <v-select v-model="sale_id" :options="allSale" label="name" multiple class="square">
                                    <template #selected-option="{ name }">
                                        <div style="display: flex; align-items: baseline;">
                                            <strong>{{ name }}</strong>
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="submitForm()"><i class="fa fa-plus"></i> Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- // Modal Setting Source-->
        <div class="modal fade text-left" id="modalSettingSource" tabindex="-1" role="dialog"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-main">
                        <h3 class="modal-title"> SINH MÃ NHÚNG SOURCE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="vue-component">
                        <div class="row">
                            <div class="col-9">
                                <div class="pu-caption">
                                    Cấu hình hiển thị
                                </div>
                                <div class="row mb-1">
                                    <div class="col-2">
                                        <span class="label fz-12">Tên source</span>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control square h30" :value="source_name">
                                    </div>
                                </div>
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
                                        <input type="color" class="form-control square h30" v-model="source.background">
                                    </div>
                                    <div class="col-2">
                                        <span class="label fz-12">Căn lề</span>
                                    </div>
                                    <div class="col-1">
                                        <select name="" class="form-control square h30" v-model="source.padding">
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
                                        <select name="" class="form-control square h30" v-model="source.border_size">
                                            <option :value="item" v-for="(item,index) in size_" :key="index">{{item}}</option>
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <select name="" class="form-control square h30" v-model="source.border_style">
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

                                <div class="row">
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

                                <div class="row">
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
                                <div class="row">
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
                                <div class="row">
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
                                <div class="row">
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
                                <div class="row">
                                    <div class="col-2">
                                        <span class="label fz-12">Thông báo thành công</span>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control square h30" v-model="source.notification">
                                    </div>
                                </div>
                                <button class="btn btn-info" @click="ngonngay"><i class="fa fa-save"></i>  Lưu</button>

                            </div>

                            <!--Xem trước-->
                            <div class="col-3">
                                <div class="pu-caption">
                                    Xem trước tiện ích
                                </div>
                                <form :action="method_form" method="post" ref="foo" style="padding: 0px 15px">
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
                                            <h2 class="text-center" v-if="source.is_title_chinh" :style="{color:source.title_chinh_color}" style="font-weight: 700;font-family:'Quicksand', 'sans-serif';margin: 20px 0 10px 0;">{{source.title_chinh}}</h2>
                                            <h2 class="text-center" v-if="source.is_title_phu" :style="{color:source.title_phu_color}" style="color: #000;font-weight: 700;font-family:   'Quicksand', 'sans-serif';margin: 20px 0 10px 0;">{{source.title_phu}}</h2>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <input type="text" class="form-control" name="full_name" v-if="source.is_name_form" :placeholder="source.name_form">
                                        </div>
                                        <div class="col-12 mb-1">
                                            <input type="text" class="form-control" name="email" v-if="source.is_email_form" :placeholder="source.email_form">
                                        </div>
                                        <div class="col-12 mb-1">
                                            <input type="text" class="form-control" name="phone" v-if="source.is_phone_form" :placeholder="source.phone_form">
                                        </div>
                                        <div class="col-12 mb-1 form-group">
                                            <textarea rows="4" class="form-control" name="content" v-if="source.is_content" :placeholder="source.content"></textarea>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <button type="submit" class="btn form-control border-0" :style="{color:source.title_button_color,background:source.button_color}">{{source.title_button}}</button>
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                allSale: [],
                allProduct: [],
                allMarketing: [],
                allSource: [],
                currentUser:null,

                //search
                searchUser: '',
                searchProduct: '',
                searchName: '',

                //form
                option_type: [
                    {id: 1, value: "Facebook"},
                    {id: 2, value: "Landing"},
                    {id: 3, value: "Website"},
                    {id: 4, value: "PartnerShip"}
                ],
                option_chanel: [
                    {id: 1, value: "Facebook"},
                    {id: 2, value: "Landing"},
                    {id: 3, value: "Website"},
                    {id: 4, value: "PartnerShip"}
                ],
                type: null,
                name: null,
                url_source: null,
                chanel: null,
                product_id: [],
                sale_id: [],
                item_update: null,
                is_validate: false,

                //Setting source
                size_:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40],
                source_id:null,
                source_name:'',
                source:{
                    source:null,
                    background:'',
                    padding:1,
                    border_color:'#ccc',
                    border_size:1,
                    border_style:'solid',
                    is_border:true,
                    title_chinh:'Đăng ký mua hàng',
                    title_chinh_color:'Đăng ký mua hàng',
                    is_title_chinh:true,
                    title_phu:'',
                    title_phu_color:'',
                    is_title_phu:true,
                    name_form:'',
                    is_name_form:true,
                    email_form:'',
                    is_email_form:true,
                    phone_form:'',
                    is_phone_form:true,
                    content:'',
                    is_content:true,
                    title_button:'Đăng ký ngay',
                    title_button_color:'',
                    button_color:'#cccccc',
                    notification:''
                },
                //mã nhúng
                code_nhung:'',
                method_form:''
            }
        },
        created() {
            this.getAllSale();
            this.getAllProduct();
            this.getAllSource();
            this.getAllMarketing();
            this.getUser();
        },
        methods: {
             nodeToString ( node ) {
                var tmpNode = document.createElement( "div" );
                tmpNode.appendChild( node.cloneNode( true ) );
                var str = tmpNode.innerHTML;
                tmpNode = node = null; // prevent memory leaks in IE
                return str;
            },
            ngonngay(){
                const template = this.$refs.foo;
                let form_html = this.nodeToString(template);
                let data = {
                    id: this.source_id,
                    form_html:form_html,
                    setting_form:JSON.stringify(this.source),
                    user_id:this.currentUser.id
                }
                axios.post('/api/update-setting-source',
                    data
                )
                    .then(res => {
                        if(res){
                            alertify.success('Lưu thành công !');
                            this.code_nhung ='<iframe src="'+location.origin+'/form/'+this.source_id+'" frameborder="0" style="width: 100%; height: 100%;"></iframe>';
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    })

            },
            getUser(){
                axios.get('/ajax/get-current-user')
                    .then(response => {
                        console.log('user',response.data.user)
                        this.currentUser = response.data.user;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            getAllSale() {
                axios.get('/ajax/get-all-sale')
                    .then(response => {
                        this.allSale = response.data.user;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            getAllProduct() {
                axios.get('/ajax/get-all-product-depot')
                    .then(res => {
                        let data = res.data.product.map(m => {
                            m['product_name'] = m.product.name;
                            return m;
                        });
                        this.allProduct = data;
                    })
                    .catch(function (error) {
                    })
            },
            getAllSource() {
                axios.get('/api/source')
                    .then(res => {
                        console.log(123132, res);
                        this.allSource = res.data.data;
                    })
                    .catch(function (error) {
                    })
            },
            getAllMarketing() {
                axios.get('/api/get-all-marketing')
                    .then(res => {
                        this.allMarketing = res.data.data;
                    })
                    .catch(function (error) {
                    })
            },
            onAccept(e, id) {
                const value = e.target.checked;
                let data = {
                    id: id,
                    value: value
                };
                axios.post('/api/update-accept-source',
                    data)
                    .then(res => {
                        if (res) {
                            alertify.success('Duyệt thành công !');
                        } else {
                            alertify.error('Duyệt không thành công !');
                        }
                    })
                    .catch(err => {
                        console.log('error', err)
                    })
            },
            openFormModal(val) {
                console.log(13123, val);
                $('#add_new_form').modal({show: true})
            },
            submitForm() { //Thêm mới Source
                // validate

                // console.log(12323, this.product_id.map(m=> m.id));
                // return;
                if (this.type === null || this.name === null || this.url_source === null || this.chanel === null || this.product_id.length == 0 || this.sale_id.length == 0) {
                    this.is_validate = true;
                    return;
                } else {
                    let url = '/api/source';
                    let data = {
                        type: this.type['id'],
                        name: this.name,
                        url_source: this.url_source,
                        chanel: this.chanel['id'],
                        product_id: this.product_id.map(m => m.id),
                        sale_id: this.sale_id.map(m => m.id),
                        user_id:this.currentUser.id
                    }
                    if (!this.item_update) { //thêm mới
                        axios.post(url,
                            data,
                        ).then(res => {
                            console.log(123, res);
                        }).catch(err => {

                        })
                    } else { //cập nhật source

                    }
                }
            },
            openFormConnect(source) {
                 this.source_id = source.id;
                 this.source_name = source.name;
                 if(source.setting_form){
                     this.source = JSON.parse(source.setting_form);
                     this.code_nhung= '<iframe src="'+location.origin+'/form/'+source.id+'" frameborder="0" style="width: 100%; height: 100%;"></iframe>';
                 }
                $('#modalSettingSource').modal({show: true});
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
    .fz-12{
        font-size: 12px;
    }
    .h30{
        height: 30px !important;
    }
</style>
