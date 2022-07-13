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
        <div class="container " style="margin-top: 100px;margin-bottom:100px;">
            <div class="row " v-if='product'>
                <div class="col-12">
                    <h1>รายละเอียดสินค้า</h1>
                </div>
                <div class="col-md-4">
                    <img :src='product.image' class='img-fluid'/>
                </div>
                <div class="col-md-8">
                        <h2>{{product.name}}</h2>
                        <h2 class="mb-3 mt-2" style="font-weight: bold !important;
    background: #f2f2f2;padding: 5px;
    ">ราคา <span style='color: #f12325;'>{{product.price}}</span> <small>บาท</small></h2>
                       
                        <div>รายละเอียดสินค้า</div>
                        <div>{{product.detail}}</div>

                        <div class='mt-3'>
                            <div class='mb-3 row'>
                                <div class="col-1"> <label>จำนวน</label></div>
                                <div class="col-2"><input :disabled="product.stock <= 0" type='number' v-model='number' class='form-control' style='text-align:center;' min='1' :max='product.stock' value='1'></div>
                                <div class="col-3"><small>มีสินค้าทั้งหมด {{product.stock}} ชิ้น</small></div>
                            </div>
                            <div v-if='product.stock <= 0'>
                                <label class='text-danger'>สินค้าหมด</label>
                            </div>
                            <button class="btn btn-success" @click="addToCart(product)" :disabled="product.stock <= 0">เพิ่มลงในตะกร้า</button>
                        </div>
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
                number:1,
                search:null,
                product: null,
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
                
                getProducts: function () {
                    let id = new URL(location.href).searchParams.get('id');
                    let url = '/api/products.php?status=find-one&id='+id;
                    if(this.search != null){
                        url += '&search='+this.search;
                    }
                    axios.get(url).then(response => {
                        const {data} = response.data;
                        this.product = data;
                    })
                },
                addToCart:function(product){


                    if(parseInt(product.stock) < parseInt(this.number)){
                        Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'จำนวนสินค้าเหลือไม่เพียงพอ',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        return false;
                    }
                    
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
                    formData.append('qty', this.number);
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