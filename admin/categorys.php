<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>หมวดหมู่</title>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content">
    <div class="container">
    <div id="app-category" class="row d-flex justify-content-center mt-5">
        <div class="col-12">
            <h3>หมวดหมู่สินค้า</h3>
            <div class="mb-3 ">
                <input type="hidden" v-model="id"/>
                <input type="text" v-model="name" placeholder="กรอกข้อมูลหมวดหมู่"/>
                <button @click="submit" class="btn btn-sm btn-success">บันทึก</button>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th class="text-center" width="10">รหัส</th>
                    <th class="text-center">หมวดหมู่</th>
                    <th class="text-center" width="190">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="categorys.length" v-for="i in categorys">
                    <td>{{i.id}}</td>
                    <td>{{i.name}}</td>
                    <td>
                        <button class="btn btn-primary" @click="setForm(i)"><i class="bi bi-pencil-square"></i> แก้ไข</button>
                        <button class="btn btn-danger" @click="removeCategory(i.id)"><i class="bi bi-trash3"></i> ลบ</button>
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
        el: '#app-category',
        data: {
            id: null,
            name: null,
            categorys: [],
        },
        created: function () {
            this.getCategory();
        },
        methods: {
            //get category all
            getCategory: function () {
                let url = '/api/categorys.php?status=find-all';
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    this.categorys = data;
                })
            },
            //set form update
            setForm: function (data) {
                this.id = data.id;
                this.name = data.name;
            },
            //remove category
            removeCategory: function (id) {
                let text = "Confirm Delete";
                if (confirm(text) == true) {
                    let formData = new FormData();
                    formData.append('id', id);
                    this.callApi(formData, 'delete');
                }
            },
            //submit insert or update
            submit: function () {

                //check field name
                if (this.name == null) {
                    Swal.fire({
                        position: 'center',
                        // icon: 'success',
                        title: 'กรุณากรอกชื่อหมวดหมู่',
                        showConfirmButton: true,
                    });
                    return false;
                }
                //check insert or update
                let status = 'create';
                if (this.id != null) {
                    status = 'update';
                }

                //set form insert or update
                let formData = new FormData();
                formData.append('name', this.name);
                if (this.id) {
                    formData.append('id', this.id);
                }//
                //call api
                this.callApi(formData, status);
            },
            callApi: function (formData, status) {
                let url = '/api/categorys.php?status=' + status;
                axios.post(url, formData).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        this.getCategory();
                        this.clearForm();
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
            clearForm: function () {
                this.name = null;
                this.id = null;
            }
        }
    })
</script>
</body>
</html>


