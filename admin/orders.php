<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>ผู้ใช้งาน</title>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content" id="app-orders">
    <div class="container">
        <h3>ผู้ใช้งาน</h3>
        <div class="row mb-3 justify-content-center">
            <h3>รายการสั่งซื้อของฉัน</h3>
            <table class="table table-responsive" v-if="orders">
                <thead>
                    <tr>
                        <th>ORDER ID</th>
                        <th>ลูกค้า</th>
                        <th>จำนวนเงิน</th>
                        <th>สถานะจัดส่ง</th>
                        <th>สถานะชำระเงิน</th>
                        <th>หลักฐานการชำระเงิน</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="orders.length" v-for="i in orders">
                        <td>{{i.id}}</td>
                        <td>{{i.user_name}}</td>
                        <td>{{new Intl.NumberFormat().format(i.total_price)}}</td>
                        <td>{{i.delivery_status}}</td>
                        <td>{{i.payment_status}}</td>
                        <td><img :src="i.image_slip" class="img-fluid" style="width:50px;height:50px;object-fit: cover;"/></td>
                        <td>{{i.create_date}}</td>
                        <td>
                            <button class="btn btn-primary" @click="mangeOrder(i.id)"><i class="bi bi-pencil-square"></i> จัดการ </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-orders',
        data: {
            orders:[]
        },
        created: function () {
            this.getOrders();
        },
        methods: {
            //get category all
            getOrders: async function () {
                this.total = 0;
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/orders.php?status=get-order-all';
                axios.get(url).then(response => {
                    const {data} = response.data;
                    this.orders = data;
                    console.log(this.orders);
                })
            },
            mangeOrder:async function(id){
                location.href = '/admin/order-detail.php?active=orders&id='+id;
            }
        }
    })
</script>
</body>
</html>