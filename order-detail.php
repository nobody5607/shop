<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>รายการสั่งซื้อ</title>
</head>
<body>

<div id="app-carts">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php'); ?>
    <!-- Close Top Nav -->
    <div class="container" style="margin-top: 100px">
        <div class="mb-3">
            <div class="row mb-3 justify-content-center" v-if="order != null">
                <h3>รายการสั่งซื้อ <button v-if='payment_status == "ชำระเงินแล้ว" ' @click='print()' class='btn btn-warning'>ปริ้นใบเสร็จ</button></h3>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div>สถานะการชำระเงิน: {{payment_status}}</div>
                            <div>สถานะการจัดส่ง: {{delivery_status}}</div>
                        </div>
                        <div>หมายเลขคำสั่งซื้อ: {{order.id}}</div>
                        <div>ที่อยู่ในการจัดส่ง:<span v-html='order.shipping_address'></span></div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-title">หลักฐานการชำระเงิน</div>
                        <div v-if="payment_status == 'กรุณาชำระเงิน'">
                            <label for="">อัปโหลดหลักฐานการชำระเงิน</label>
                            <div><input type="file" @change="uploadFile" accept="image/*"></div>
                            <div class="mt-2">
                                <button @click="uploadSlip" class="btn btn-primary">ยืนยัน</button>
                            </div>
                        </div>
                        <div v-if="image != '' ">
                            <img :src="image" class="img-fluid" style="width:250px;height:250px;object-fit: cover;"/>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-title">รายการสินค้า</div>
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>ราคา</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-if="order.order_detail" v-for="i in order.order_detail">
                                    <td><img :src="i.product_image" style="width:50px;height:50px;object-fit: cover;"/> {{i.product_name}}</td>
                                    <td>{{i.qty}}</td>
                                    <td>{{i.price * i.qty}} บาท</td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td>รวมค่าสินค้า</td>
                                <td><b>{{new Intl.NumberFormat().format(order.total_price)}} บาท</b></td>
                            </tr>
                            </tfoot>
                        </table>
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
            order: null,
            image:'',
            file:'',
            delivery_status:'',
            payment_status:''
        },
        created() {
            this.getOrderById();
        },
        methods: {
            print:function(){
                let id = new URL(location.href).searchParams.get('id');
                const url = 'print.php?id='+id;
                window.open(url, '_blank')
            },
            getOrderById: async function () {
                let id = new URL(location.href).searchParams.get('id');
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/orders.php?status=get-order-by-id&order_id=' + id+'&user_id='+user_id;
                axios.get(url).then(response => {
                    const {data} = response.data;
                   this.order = data;
                   if(this.order.image_slip){
                       this.image = this.order.image_slip;
                   }
                   if(this.order.payment_status){
                       this.payment_status = this.order.payment_status;
                   }
                    if(this.order.delivery_status){
                        this.delivery_status = this.order.delivery_status;
                    }
                    //console.log(this.payment_status)

                })
            },

            uploadSlip:async function(){
                const user_id = localStorage.getItem('id');
                const order_id = this.order.id;
                const formData = new FormData();
                formData.append('user_id',user_id);
                formData.append('order_id',order_id);
                formData.append('image_slip',this.file);
                let url = '/api/orders.php?status=upload-slip';
                axios.post(url,formData).then(response => {
                    const {status,message} = response.data;
                    this.file = '';
                    if(status === 'success'){
                        Swal.fire({
                            position: 'center',
                            icon: status,
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        this.getOrderById();
                    }
                })

            },
            uploadFile:function(e){
                const file = e.target.files[0];
                this.createBase64(file)
                this.image = URL.createObjectURL(file);

                e.preventDefault();
            },
            createBase64:function(file){
                const reader = new FileReader()
                reader.onloadend = () => {
                    this.file = reader.result;
                }
                reader.readAsDataURL(file);
            }
        }
    })
</script>
</body>
</html>


