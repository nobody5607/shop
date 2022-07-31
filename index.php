<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./layout/head.php')?>
    <style>
        .h3.text-decoration-none.text-center {
            height: 50px;
            /* background: blue; */
            overflow: hidden;
        }
    </style>
    <title>App</title>
</head>

<body>
<div id="app-products" style='height: 100vh;'>
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php');?>
    <!-- Close Top Nav -->

    <div  class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 pb-4 pt-4">
                <div class="d-flex">
                    <input @change="searchProduct" type="text" class="form-control" placeholder="ค้นหาสินค้า Enter">
                </div>
            </div>
        </div>
        <div id="shop" class="row">
            <div class="col-md-3" v-if="products.length" v-for="i in products" style='cursor:pointer;' @click='detail(i)'>
                <div class="card mb-4 product-wap rounded-0">
                    <div class="card rounded-0">
                        <img class="card-img rounded-0 img-fluid" :src="i.image" style="height: 400px;object-fit: cover">
                    </div>
                    <div class="card-body">
                        <div class="h3 text-decoration-none text-center">{{i.name}}</div>

                        <div class="row mt-3">
                            <div class="col-6"> 
                                <p class="text-center mb-0" style="font-weight: bold !important;">{{i.price}} <small>บาท</small></p>
                            </div>
                            <div class="col-6">
                            <div v-if='i.stock <= 0'>
                                        <label class='text-danger'>สินค้าหมด</label>
                                    </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </div>

        <div id="about" class="mt-3">
            <h3>ติดต่อเรา</h3>
            <div class="text-center">
                หจก.รัฐพงษ์ธัญญพืชสาโทแอนด์ไวน์ ที่อยู่ 32 หมู่ 1 ต.ธาตุนาเวง อ.เมือง จ.สกลนคร รหัสไปรษณีย์ 47000 โทร 081-6618186
            </div>
        </div>
        <div id="contact" class="mt-3">
            <h3>ที่ตั้งเรา</h3>
            <div class="justify-content-center" style="display: flex">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1329.0350770936166!2d104.12098188721708!3d17.19188244914297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313c8d86e7de4bb9%3A0x7431fcbc0b8b0aba!2z4Lir4LiI4LiBLuC4o-C4seC4kOC4nuC4h-C4qeC5jOC4mOC4seC4jeC4nuC4t-C4iuC4quC4suC5guC4l-C5geC4reC4meC4lOC5jOC5hOC4p-C4meC5jA!5e0!3m2!1sen!2sth!4v1656609705047!5m2!1sen!2sth" width="1024" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div id="how-to-order" class="mt-3">
            <h3>วิธีการสั่งซื้อ</h3>
            <div>

            </div>
        </div>


    </div>




    <?php require('./layout/footer.php')?>
    <!-- End Footer -->

   <?php require ('./layout/script.php')?>
</div>
    <script>
        new Vue({
            el: '#app-products',
            data: {
                search:null,
                products: [],
            },
            created: function () {
                this.getProducts();
                if(this.checkLogin()){
                    this.getCountCart();
                }
            },
            methods: {
                checkLogin:function(){
                    let user_id = localStorage.getItem('id');
                    if(!user_id){
                        return false;
                    }else{
                        return true;
                    }
                },
                detail:function(product){
                    location.href = 'product-detail.php?id='+product.id;
                },
                //getCountCart
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
                //get category all
                searchProduct:function(e){
                    this.search = e.target.value;
                    this.getProducts();
                },
                getProducts: function () {
                    let url = '/api/products.php?status=find-all';
                    if(this.search != null){
                        url += '&search='+this.search;
                    }
                    axios.get(url).then(response => {
                        const {data} = response.data;
                        this.products = data;
                    })
                },
                addToCart:function(product){
                    let user_id = localStorage.getItem('id');
                    if(!user_id){
                        $("#modalLogin").modal('show');
                        return false;
                    }
                    let url = '/api/carts.php?status=add';
                    let formData = new FormData();

                    formData.append('product_id', product.id);
                    formData.append('product_name', product.name);
                    formData.append('image', product.image);
                    formData.append('qty', 1);
                    formData.append('price', product.price);
                    formData.append('user_id', localStorage.getItem('id'));
                    axios.post(url, formData).then(response => {
                        const {data,status,message} = response.data;
                        if(status === 'success'){
                            $('#cart-number').text(data.count_cart);
                            Swal.fire({
                                position: 'center',
                                icon: status,
                                title: message,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }

                    })
                }

            }
        })
    </script>


<div class="modal" tabindex="-1" id="modalLogin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php require ('login.php')?>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 150px"></div>
    <!-- End Script -->
</body>

</html>