<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>

    <title>Order</title>
</head>
<body>

<div id="app-carts" class="">
    <!-- Start Top Nav -->
    <?= require('./navbar-left.php') ?>
    <!-- Close Top Nav -->
    <div class="content" >
        <div class="container " style="padding-left: 35px">
            <div class="mb-3">
                <div class="row mb-3 justify-content-center" v-if="order != null">
                    <a href="/admin/orders.php?active=orders">ย้อนกลับ</a>
                    <h3>รายการสั่งซื้อ</h3>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div>
                                <label for="">สถานะการชำระเงิน</label>
                                <select :disabled='order.delivery_status == 3' class="" v-model="payment_status">
                                    <option value="0">กรุณาชำระเงิน</option>
                                    <option value="1">รอดำเนินการ</option>
                                    <option value="2">ชำระเงินแล้ว</option>
                                </select>
                            </div>
                            <div>
                                <label for="">สถานะการจัดส่ง</label>
                                <select :disabled='order.delivery_status == 3' class="" v-model="delivery_status">
                                    <option value="0">รอดำเนินการ</option>
                                    <option value="1">กำลังจัดส่ง</option>
                                    <option value="2">จัดส่งสำเร็จ</option>
                                    <option value="3">ยกเลิก</option>
                                </select>
                            </div>
                            <div v-if='order.delivery_status != 3'>
                                <button @click="updateOrderStatus(order)" class="btn btn-primary mt-3">อัปเดทสถานะการสั่งซื้อ</button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div>หมายเลขคำสั่งซื้อ: {{order.id}}</div>
                            <div>ที่อยู่ในการจัดส่ง:<span v-html='order.shipping_address'></span></div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="card-title">หลักฐานการชำระเงิน</div>
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
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-center">ราคา</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="order.order_detail" v-for="i in order.order_detail">
                                    <td><img :src="i.product_image" style="width:50px;height:50px;object-fit: cover;"/> {{i.product_name}}</td>
                                    <td class="text-right">{{i.qty}}</td>
                                    <td class="text-right">{{i.price * i.qty}} บาท</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr class="text-right">
                                    <td></td>
                                    <td style="text-align: right;">รวมค่าสินค้า</td>
                                    <td style="text-align: right;"><b>{{new Intl.NumberFormat().format(order.total_price)}} บาท</b></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 100px"></div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-carts',
        data: {
            order: null,
            image:'',
            file:'',
            delivery_status:'0',
            payment_status:'0'
        },
        created() {
            this.getOrderById();
        },
        methods: {
            getOrderById: async function () {
                let id = new URL(location.href).searchParams.get('id');
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/orders.php?backend=1&status=get-order-by-id&order_id=' + id+'&user_id='+user_id;
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

                })
            },
            updateOrderStatus:function(order){
                const formData = new FormData();
                formData.append('order_id', order.id);
                formData.append('delivery_status', this.delivery_status);
                formData.append('payment_status', this.payment_status);
                const url = '/api/orders.php?status=update-order-status';
                axios.post(url, formData).then(response => {
                    const {status,message} = response.data;
                    Swal.fire({
                        position: 'center',
                        icon: status,
                        title: message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                })
            }
        }
    })
</script>
</body>
</html>


