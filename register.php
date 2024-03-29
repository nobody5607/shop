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
                    <label class="form-label">ชื่อผู้ใช้งาน <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="username">
                </div>
                <div class="mb-3">
                    <label class="form-label">รหัสผ่าน <span class='text-danger'>*</span></label>
                    <input type="password" class="form-control" required v-model="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">ชื่อ นามสกุล <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์ <span class='text-danger'>*</span></label>
                    <input type="text" class="form-control" required v-model="phone">
                </div>

                <div class="mb-3">
                    <label class="form-label">ที่อยู่ <span class='text-danger'>*</span></label>
                    <textarea name="shipping_address"  cols="30" rows="5" required class='form-control' v-model='shipping_address'></textarea>
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
                shipping_address:null
            },
            created: function () {
                
            },
            methods: {
                
                isPhoneNo:function(input){
                    var regExp = /^0[0-9]{8,9}$/i;
                    return regExp.test(input);
                },
                submit: function (e) {
                    e.preventDefault();
                    if(this.isPhoneNo(this.phone) == false){
                        Swal.fire({
                                position: 'center',
                                icon: "warning",
                                title: "กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        return false;
                    }

                //set form insert or update
                let formData = new FormData();
                formData.append('username', this.username);
                formData.append('password', this.password);
                formData.append('name', this.name);
                formData.append('phone', this.phone);
                formData.append('role', 'user');
                formData.append('shipping_address', this.shipping_address);

                
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
               
            }
           
            }
        })
    </script>


 
 
    <!-- End Script -->
</body>

</html>