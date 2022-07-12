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
<div id="app-products"  class='d-flex flex-column h-100'>
    <!-- Start Top Nav -->
    <?php require('./layout/navbar.php');?>
    <!-- Close Top Nav -->
    <div  class="container" style="margin-top: 100px">
    <h2>สมัครสมาชิก</h2>

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
    <!-- End Footer -->

   <?php require ('./layout/script.php')?>
</div>
    <script>
        new Vue({
            el: '#app-products',
            data: {
                id:null,
                username:null,
                password:null,
                name:null,
                phone:null,
            },
            created: function () {
                
            },
            methods: {
                submit: function (e) {
                //check insert or update

                //set form insert or update
                let formData = new FormData();
                formData.append('username', this.username);
                formData.append('password', this.password);
                formData.append('name', this.name);
                formData.append('phone', this.phone);
                formData.append('role', 'user');
                let status = 'create';
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
                            location.href = 'index.php';
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


 
 
    <!-- End Script -->
</body>

</html>