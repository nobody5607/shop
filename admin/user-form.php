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
            <h3>เพิ่มผู้ใช้งาน</h3>
            <form @submit="submit">
                <div class="mb-3">
                    <label class="form-label">ชื่อผู้ใช้งาน</label>
                    <input type="text" class="form-control" required v-model="username">
                </div>
                <div class="mb-3">
                    <label class="form-label">รหัสผ่าน</label>
                    <input type="password" class="form-control" required v-model="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">ชื่อ นามสกุล</label>
                    <input type="text" class="form-control" required v-model="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" required v-model="phone">
                </div>
                <div class="mb-3">
                    <label class="form-label">บทบาท</label>
                    <select class="form-control" v-model="role" required>
                        <option value="">เลือกบทบาท</option>
                        <option value="user">ลูกค้า</option>
                        <option value="admin">ผู้ดูแลระบบ</option>
                    </select>
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
        el: '#app-user',
        data: {
            id:null,
            username:null,
            password:null,
            name:null,
            phone:null,
            role:null
        },
        created: function () {
            this.username = 'user';
            this.password = '123456';
            this.name = 'user service';
            this.phone = '191';
            this.role = 'user';

            //get user by id
            let id = new URL(location.href).searchParams.get('id');
            if(id){
                this.getUserById(id);
            }

        },
        methods: {
            //get user by id
            getUserById:function(id){
                //call api
                let url = '/api/users.php?status=find-one' + '&id='+id;
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    //insert or update success
                    if (status == 'success') {
                        this.id = data.id;
                        this.username = data.username;
                        this.password = data.password;
                        this.name = data.name;
                        this.phone = data.phone;
                        this.role = data.role;
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
                formData.append('username', this.username);
                formData.append('password', this.password);
                formData.append('name', this.name);
                formData.append('phone', this.phone);
                formData.append('role', this.role);
                let status = 'create';
                if (this.id) {
                    status = 'update';
                    formData.append('id', this.id);
                }//
                //call api
                let url = '/api/users.php?status=' + status;
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
                            location.href = '/admin/users.php?active=users';
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
            }
        }
    })
</script>
</body>
</html>


