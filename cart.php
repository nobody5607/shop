<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>ตะกร้าสินค้า</title>
</head>
<body>

<div id="app-carts">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php'); ?>
    <!-- Close Top Nav -->
    <div class="container" style="margin-top: 100px">
        <div class="mb-3">
            <div class="row mb-3 justify-content-center">

                <div class="col-md-6">
                    <h3>ทำการสั่งซื้อ</h3>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-title">
                                <label for=""><b>ที่อยู่สำหรับจัดส่ง</b></label>
                            </div>
                            <form action="#">
                                <div class="mb-3">
                                    <label>ชื่อนามสกุล</label>
                                    <input type="text" class="form-control" v-model="user.shipping_name">
                                </div>
                                <div class="mb-3">
                                    <label>ที่อยู่สำหรับจัดส่ง</label>
                                    <textarea type="text" class="form-control" v-model="user.shipping_address"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" v-model="user.shipping_phone">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mb-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">รายการสินค้า</div>
                                <table class="table table-responsive table-bordered">
                                    <thead>
                                    <tr>
                                        <th>รายการ</th>
                                        <th>จำนวน</th>
                                        <th>ราคาต่อหน่วย</th>
                                        <th>รวม</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="c in carts">
                                        <td width="200">{{c.product_name}}</td>
                                        <td width="100">
                                            <input @change="updateCart" :id="c.id" type="number" :value="c.qty"
                                                   class="form-control text-center"/>
                                        </td>
                                        <td>{{new Intl.NumberFormat().format(c.price)}} บาท</td>
                                        <td>{{new Intl.NumberFormat().format(c.price * c.qty)}} บาท</td>
                                        <td >
                                            <button @click="deleteCart(c.id)" class="btn btn-danger">ลบ</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                                        <div class="col-12">
                                        <div class="card">
                            <div class="card-body">
                            <table>
                                                <tr>
                                                    <td>ยอดรวมสินค้า:</td>
                                                    <td><b>{{total}}</b> บาท</td>
                                                </tr>
                                                <tr>
                                                    <td>รวมการจัดส่ง:</td>
                                                    <td><b>0</b> บาท</td>
                                                </tr>
                                                <tr>
                                                    <td>การชำระเงินทั้งหมด:</td>
                                                    <td><b>{{total}}</b> บาท</td>
                                                </tr>
                                            </table>
                            </div>
                        </div>
                                            
                                        </div>
                                    </div>
                        
                    </div>

                    <div class="mb-3 d-flex flex-row-reverse bd-highlight">
                        <button @click="checkout()" class="btn btn-warning btn-lg">สั่งสินค้า</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 100px"></div>
<!-- Start Footer -->
<?php require('./layout/footer.php') ?>
<!-- End Footer -->

<?php require('./layout/script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-carts',
        data: {
            carts: [],
            user:{
                shipping_name:'',
                shipping_address:'',
                shipping_phone:''
            },
            total: 0,
        },
        created() {
            this.getCarts();
            this.getUserById();
            this.getCountCart();
        },
        methods: {
            getCarts: async function () {
                this.total = 0;
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/carts.php?status=find-all&user_id=' + user_id;
                axios.get(url).then(response => {
                    const {data} = response.data;
                    this.carts = data;
                    for (let i of this.carts) {
                        this.total += i.price * i.qty;
                    }
                    this.total = new Intl.NumberFormat().format(this.total);
                })
            },
            deleteCart: function (id) {
                let text = "Confirm Delete";
                if (confirm(text) == true) {
                    let formData = new FormData();
                    formData.append('id', id);
                    let url = '/api/carts.php?status=delete';
                    axios.post(url, formData).then(response => {
                        const {status, message} = response.data;
                        Swal.fire({
                            position: 'center',
                            icon: status,
                            title: message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.getCarts();
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },
            updateCart: function (event) {
                const qty = event.target.value;
                const id = event.target.id;
                let formData = new FormData();
                formData.append('id', id);
                formData.append('qty', qty);
                let url = '/api/carts.php?status=update-cart';
                axios.post(url, formData).then(response => {
                    const {status, message} = response.data;
                    Swal.fire({
                        position: 'center',
                        icon: status,
                        title: message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getCarts();
                }).catch(error => {
                    console.log(error);
                });

            },
            getCountCart:function(e){

                let user_id = localStorage.getItem('id');

                if(user_id){
                    let url = '/api/carts.php?status=get-count';
                    let formData = new FormData();
                    formData.append('user_id', localStorage.getItem('id'));
                    axios.post(url, formData).then(response => {
                        const {data,status} = response.data;
                        console.log(data);
                        if(status === 'success'){
                            $('#cart-number').text(data.count_cart);
                        }

                    })
                }else{
                    $('#cart-number').text(0);
                }

            },
            getUserById:function(){
                const id = localStorage.getItem('id');
                const url = '/api/users.php?status=find-one' + '&id='+id;
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        this.user.shipping_name = data.shipping_name;
                        this.user.shipping_address = data.shipping_address;
                        this.user.shipping_phone = data.shipping_phone;
                    }
                }).catch(error => console.log(error));
            },
            updateShipping:function(){
                let formData = new FormData();
                formData.append('id' , localStorage.getItem('id'));
                formData.append('shipping_name' , this.user.shipping_name);
                formData.append('shipping_address' , this.user.shipping_address);
                formData.append('shipping_phone' , this.user.shipping_phone);
                const url = '/api/users.php?status=update-shipping';
                axios.post(url, formData).then(response => {
                    console.log(response.data);
                }).catch(error=>{
                    console.log(error);
                })
            },
            checkout: function () {

                if(this.user.shipping_name == '' || this.user.shipping_address == '' || this.user.shipping_phone ==''){
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'กรุณากรอกที่อยู่สำหรับจัดส่ง',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return false;
                }
                //update shipping
                this.updateShipping();
                //end update shipping
                const order_id = '<?= date('YmdHis').rand(1,1000)?>';
                const id = localStorage.getItem('id');

                const shipping_address = `
                    ชื่อนามสกุล: ${this.user.shipping_name}<br/>
                    ที่อยู่: ${this.user.shipping_address}<br/>
                    เบอร์โทรศัพท์: ${this.user.shipping_phone}<br/>
                `;

                let formData = new FormData();
                formData.append('user_id' , id);
                formData.append('order_id' , order_id);
                formData.append('shipping_address', shipping_address);
                const url = '/api/orders.php?status=add';

                axios.post(url, formData).then(response=>{
                    const {data, status, message} = response.data;
                    Swal.fire({
                        position: 'center',
                        icon: status,
                        title: message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    if(status === 'success'){
                        location.href='order-detail.php?id='+order_id;
                    }
                }).catch(error=>console.log(error));
            }
        }
    })
</script>
</body>
</html>


