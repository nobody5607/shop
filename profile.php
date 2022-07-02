<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>

    <title>โปรไฟล์</title>
</head>
<body>

<div id="app-carts">
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php'); ?>
    <!-- Close Top Nav -->
    <div class="container" style="margin-top: 100px">
        <div class="mb-3">
            <div class="row mb-3 justify-content-center">
                <h3>โปรไฟล์</h3>
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

                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
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
            id:null,
            username:null,
            password:null,
            name:null,
            phone:null,
            role:null
        },
        created() {
            this.getProfile();
        },
        methods: {
            getProfile: async function () {
                const user_id = localStorage.getItem('id');
                const url = '/api/users.php?status=find-one' + '&id='+user_id;
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
            submit: async function(e){
                let formData = new FormData();
                formData.append('username', this.username);
                formData.append('password', this.password);
                formData.append('name', this.name);
                formData.append('phone', this.phone);
                formData.append('id', this.id);

                const url = '/api/users.php?status=update-profile';
                axios.post(url, formData).then(response => {
                    const {status, message} = response.data;
                    Swal.fire({
                        position: 'center',
                        icon: status,
                        title: message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if(status === 'success'){
                        localStorage.setItem('name', this.name);
                        localStorage.setItem('phone', this.phone);
                        setTimeout(function (){
                            location.reload();
                        },2000);
                    }
                }).catch(error => console.log(error));
                e.preventDefault();
            }
        }
    })
</script>
</body>
</html>


