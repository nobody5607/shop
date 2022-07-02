<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>Order</title>
</head>
<body>

<div id="app-carts">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php'); ?>
    <!-- Close Top Nav -->
    <div class="container" style="margin-top: 100px">
        <div class="mb-3">
            <div class="row mb-3 justify-content-center">
                <h3>รายการสั่งซื้อ</h3>

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

        },
        methods: {
            getCarts: async function () {
                this.total = 0;
                const user_id = localStorage.getItem('id');
                let url = '/api/carts.php?status=find-all&user_id=' + user_id;
                axios.get(url).then(response => {

                })
            },
        }
    })
</script>
</body>
</html>


