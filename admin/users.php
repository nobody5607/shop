<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>ผู้ใช้งาน</title>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content">
    <div class="container">
        <div id="app-user" class="row d-flex justify-content-center">
            <div class="col-12">
                <h3>ผู้ใช้งาน</h3>
                <!--            search user-->
                <div class="mb-3 ">
                    <div class="row">
                        <div class="col-6">
                            <a href="/admin/user-form.php?active=users" class="btn btn-success"><i class="bi bi-plus-lg"></i>
                                เพิ่มผู้ใช้งาน</a>
                        </div>
                        <div class="col-6 d-flex justify-content-end">

                            <input type="text" v-model="search" placeholder="ค้นหาผู้ใช้"/>&nbsp;
                            <button @click="getUsers" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th class="text-center">ชื่อผู้ใช้</th>
                        <th class="text-center">ชื่อนามสกุล</th>
                        <th class="text-center">เบอร์โทรศัพท์</th>
                        <th class="text-center">บทบาท</th>
                        <th class="text-center" width="190">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="users.length" v-for="i in users">
                        <td>{{i.username}}</td>
                        <td>{{i.name}}</td>
                        <td>{{i.phone}}</td>
                        <td>{{i.role}}</td>
                        <td>
                            <button class="btn btn-primary" @click="edit(i.id)"><i class="bi bi-pencil-square"></i>
                                แก้ไข
                            </button>
                            <button class="btn btn-danger" @click="removeUser(i.id)"><i class="bi bi-trash3"></i> ลบ
                            </button>
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
        el: '#app-user',
        data: {
            search: null,
            users: [],
        },
        created: function () {
            this.getUsers();
        },
        methods: {
            //get category all
            getUsers: function () {
                let url = '/api/users.php?status=find-all';
                if (this.search != null) {
                    url += '&search=' + this.search;
                }
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    this.users = data;
                })
            },
            //set form update
            edit: function (id) {
                location.href = '/admin/user-form.php?id=' + id+'&active=users';
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
                let url = '/api/users.php?status=' + status;
                axios.post(url, formData).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        this.getUsers();
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


