<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>สินค้า</title>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content">
    <div class="container">
        <div id="app-products" class="row d-flex justify-content-center">
            <div class="col-12">
                <h3>สินค้า</h3>
                <!--            search user-->
                <div class="mb-3 ">
                    <div class="row">
                        <div class="col-6">
                            <a href="/admin/product-form.php?active=products" class="btn btn-success"><i class="bi bi-plus-lg"></i> เพิ่มสินค้า</a>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <input type="text" v-model="search" placeholder="ค้นหาผู้ใช้"/>&nbsp;
                            <button @click="getProducts" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> ค้นหา</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th class="text-center">ชื่อสินค้า</th>
                        <th class="text-center" width="190">ราคา</th>
                       
                        <th class="text-center" width="190">รูปสินค้า</th>
                        <th class="text-center" width="190">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="products.length" v-for="i in products">
                        <td>{{i.name}}</td>
                        <td class="text-end">{{i.price}}</td>
                        
                        <td><img :src="i.image" class="img-fluid" style="width:100px;object-fit: contain;height: 100px;"></td>
                        <td class="text-center">
                            <button class="btn btn-primary" @click="edit(i.id)"><i class="bi bi-pencil-square"></i> แก้ไข </button>
                            <button class="btn btn-danger" @click="removeUser(i.id)"><i class="bi bi-trash3"></i> ลบ</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-products',
        data: {
            search:null,
            products: [],
        },
        created: function () {
            this.getProducts();
        },
        methods: {
            //get category all
            getProducts: function () {
                let url = '/api/products.php?status=find-all';
                if(this.search != null){
                    url += '&search='+this.search;
                }
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    this.products = data;
                })
            },
            //set form update
            edit: function (id) {
                location.href = '/admin/product-form.php?id='+id+'&active=products';
            },
            //remove category
            removeUser: function (id) {
                let text = "Confirm Delete";
                if (confirm(text) == true) {
                    let formData = new FormData();
                    formData.append('id', id);
                    this.callApi(formData, 'delete');
                }
            },
            callApi: function (formData, status) {
                let url = '/api/products.php?status=' + status;
                axios.post(url, formData).then(response => {
                    const {status, message} = response.data;
                    if (status == 'success') {
                        this.getProducts();
                        Swal.fire({
                            position: 'center',
                            icon: status,
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: status,
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }).catch(error => console.log(error));
            },

        }
    })
</script>
</body>
</html>


