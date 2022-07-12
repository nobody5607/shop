<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>รายการสั่งซื้อ</title>
</head>
<body>

<div id="app-carts">
    <div class="container mt-5" style='width: 1000px;'>
        
            <h3 class='text-center'>บิลเติมรูปแบบ (Receipt) #{{id}}</h3>
            <div class="row justify-content-md-center">
                <div class='col-7'>
                    <img src="../assets/img/logo.jpg" class="img-fluid" style="width:200px;height:200px; object-fit: contain;"/>
                    <div>หจก.รัฐพงษ์ธัญญพืชสาโทแอนด์ไวน์</div>
                </div>
                <div class='col-5' v-if='order'>
                    <h4>รายละเอียดลูกค้าคนสำคัญ</h4>
                    <div v-html='order.shipping_address'></div>
                    <div>วันที่: {{order.create_date}}</div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th class='text-center'>รายการสินค้า</th>
                                <th class='text-center' style='width:150px'>จำนวน</th>
                                <th class='text-center'>ราคา</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-if="order" v-for="i in order.order_detail">
                                    <td><img :src="i.product_image" style="width:50px;height:50px;object-fit: cover;"/> {{i.product_name}}</td>
                                    <td class='text-center'>{{i.qty}}</td>
                                    <td class='text-end'>{{i.price * i.qty}} บาท</td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td class='text-end'>รวมค่าสินค้า</td>
                                <td class='text-end'><b>{{new Intl.NumberFormat().format(order.total_price)}} บาท</b></td>
                            </tr>
                            </tfoot>
                        </table>
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
            payment_status:'',
            id:''
        },
        created() {
            this.getOrderById();
        },
        methods: {
            getOrderById: async function () {
                let id = new URL(location.href).searchParams.get('id');
                this.id = id;
                const user_id = localStorage.getItem('id');
                if(user_id == null){
                    location.href='/index.php';
                }
                let url = '/api/orders.php?status=get-order-by-id&order_id=' + id+'&user_id='+user_id;
                axios.get(url).then(response => {
                    const {data} = response.data;
                    console.log(data);
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
                    setTimeout(function(){
                        window.print();
                    },1000);

                })
            }, 
        }
    })
</script>
</body>
</html>


