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
<div id="app-products">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php');?>
    <!-- Close Top Nav -->

    <div  class="container" style="margin-top: 100px">
        <div class="row">
            <div class="col-md-6 pb-4 pt-4">
                <div class="d-flex">
                    <input @change="searchProduct" type="text" class="form-control" placeholder="ค้นหาสินค้า">
                </div>
            </div>
        </div>
        <div id="shop" class="row">
            <div class="col-md-3" v-if="products.length" v-for="i in products">
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
                                <button class="btn btn-success" @click="addToCart(i)">Add To Cart</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </div>

        <div id="about">
            <h3>เกี่ยวกับเรา</h3>
        </div>
        <div id="contact">
            <h3>ติดต่อเรา</h3>
        </div>
        <div id="how-to-order">
            <h3>วิธีการสั่งซื้อ</h3>
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