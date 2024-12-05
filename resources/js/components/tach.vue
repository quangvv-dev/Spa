
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
