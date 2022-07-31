<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>รายการสินค้า</title>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content">
<div class="container">
    <div id="app-product" class="row d-flex justify-content-center">
        <div class="col-12">
            <h3>เพิ่มรายการสินค้า</h3>
            <form @submit="submit">
                <div class="mb-3">
                    <label class="form-label">ชื่อสินค้า <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">รายละเอียดสินค้า </label>
                    <textarea name="detail"  cols="30" rows="5" class='form-control' v-model='detail'></textarea>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">จำนวน <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="stock">
                </div>

                <div class="mb-3">
                    <label class="form-label">ราคา <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="price">
                </div>
                
                <div class="mb-3">
                    <img :src="image" class="img-fluid" style="width: 100px;height:100px;object-fit: contain"/>
                </div>


                <div class="mb-3">
                    <label class="form-label">รูปสินค้าแรก</label>
                    <input type="file" @change="setImage" accept="image/*">
                </div>


                <button type="submit" class="btn btn-primary">บันทึก</button>
            </form>
        </div>
    </div>
</div>
</div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-product',
        data: {
            id:null,
            name:null,
            stock:0,
            price:null,
            image:null, 
            detail:null,
        },
        created: function () {
            this.name = 'Test';
            this.price = 100.00;
            this.image = '';
            this.stock = 0;
            this.detail = "Test";
            //get user by id
            let id = new URL(location.href).searchParams.get('id');
            if(id){
                this.getProductById(id);
            }

        },
        methods: {
            //get user by id
            getProductById:function(id){
                //call api
                let url = '/api/products.php?status=find-one' + '&id='+id;
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        this.id = data.id;
                        this.name = data.name;
                        this.price = data.price;
                        this.stock =  data.stock;
                        this.detail =  data.detail;
                        this.image =  data.image;
                    } else {
                        Swal.fire({
                            position: 'center',
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }).catch(error => console.log(error));
            },
            //submit insert or update
            submit: function (e) {
                //check insert or update

                //set form insert or update
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('stock', this.stock);
                formData.append('price', this.price);
                formData.append('image', this.image);
                formData.append('detail', this.detail); 

                let status = 'create';
                if (this.id) {
                    status = 'update';
                    formData.append('id', this.id);
                }//
                //call api
                let url = '/api/products.php?status=' + status;
                axios.post(url, formData).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: status,
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setTimeout(function(){
                            location.href = '/admin/products.php?active=products';
                        },2000);
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
                e.preventDefault();
            },
            setImage:function(e){
                let img = e.target.files[0];
                this.createBase64(img)
            },
            createBase64:function(file){
                const reader = new FileReader()

                reader.onloadend = () => {
                    this.image = reader.result;
                    // this.image = reader.result.toString();
                }
                reader.readAsDataURL(file);


            }

        }
    })
</script>
</body>
</html>


