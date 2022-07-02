<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>รายการสั่งซื้อของฉัน</title>
</head>
<body>

<div id="app-carts">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php'); ?>
    <!-- Close Top Nav -->
    <div class="container" style="margin-top: 100px">
        <div class="mb-3">
            <div class="row mb-3 justify-content-center">
                <h3>รายการสั่งซื้อของฉัน</h3>
                <div class="card mt-3" v-for="i in orders">
                    <div class="card-body">
                        <div class="order-title">หมายเลขคำสั่งซื้อ:{{i.id}} </div>
                        <div>สถานะการชำระเงิน: {{i.payment_status}}</div>
                        <div>สถานะการจัดส่ง: {{i.delivery_status}}</div>

                        <div class="row mt-2" v-for="d in i.order_detail">
                            <div class="col-2 " >
                                <img :src="d.product_image" style="width:50px;height:50px;object-fit: cover;"/>
                            </div>
                            <div class="col-6">
                                <label>{{d.product_name}}</label>
                            </div>
                            <div class="col-2">
                                จำนวน {{d.qty}}
                            </div>
                            <div class="col-2 text-end" >
                                <label>
                                    {{new Intl.NumberFormat().format(d.price * d.qty)}}บาท</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0" style="background-color: rgba(247, 156, 156, 0.05);
    justify-content: flex-end;
    align-items: flex-end;
    display: flex;">
                        <div class="text-right">
                            <div>ค่าจัดส่ง: <span>0 บาท</span></div>
                            <div>ยอดคำสั่งซื้อทั้งหมด: <span style="font-size: 20px;font-weight: 100;color: #FF5722;padding-left:5px;">{{new Intl.NumberFormat().format(i.total_price)}} บาท</span></div>
                            <div class="py-2">
                                <a href="#" @click="orderDetail(i.id)" class="btn btn-info">ดูข้อมูลการสั่งซื้อ</a>
                            </div>
                        </div>
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
            orders:[]
        },
        created() {
            this.getOrders();
        },
        methods: {
            getOrders: async function () {
                this.total = 0;
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/orders.php?status=get-order-all-by-user&user_id=' + user_id;
                axios.get(url).then(response => {
                    const {data} = response.data;
                    this.orders = data;
                    console.log(this.orders);
                })
            },
            orderDetail: async function(id){
                location.href='/order-detail.php?id='+id;
            }
        }
    })
</script>
</body>
</html>


