<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>

<div id="app-login" class="row d-flex justify-content-center">

    <div class="col-md-12">
        <p v-if="errors.length">
        <ul>
            <li v-for="error in errors" class="text-danger">{{ error }}</li>
        </ul>
        </p>
        <form>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="username">ชื่อผู้ใช้งาน</label>
                <input type="text" id="username" class="form-control" v-model="username"/>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">รหัสผ่าน</label>
                <input type="password" id="password" class="form-control" v-model="password"/>
            </div>


            <!-- Submit button -->


            <div class="d-grid gap-2">
                <button @click="submit" class="btn btn-primary btn-block mb-4">เข้าสู่ระบบ</button>
                <a href='register.php' class="btn btn-link mb-4">สมัครสมาชิก</a>
            </div>
        </form>
    </div>
</div>

<script>
    new Vue({
        el: '#app-login',
        data: {
            errors: [],
            username: 'admin',
            password: '123456'
        },
        methods: {
            submit: async function (e) {
                //validate username or password
                if (this.username && this.password) {

                    //set formdata
                    let formData = new FormData();
                    formData.append('username', this.username);
                    formData.append('password', this.password);

                    //request api login method post
                    let url = '/api/login.php';
                    axios.post(url, formData).then(response => {
                        const {data, status, message} = response.data;
                        //login success
                        if (status === 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'เข้าสู่ระบบสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            //set local storage
                            setTimeout(()=>{
                                localStorage.setItem('id', data.id);
                                localStorage.setItem('name', data.name);
                                localStorage.setItem('role', data.role);
                                localStorage.setItem('phone', data.phone);
                                location.href = '/';

                            },1500)
                        } else {
                            //login fail
                            Swal.fire({
                                position: 'center',
                                icon: status,
                                title: message,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    }).catch(error=>{
                        console.log(error);
                    });


                }

                //validate form
                this.errors = [];
                if (!this.username) {
                    this.errors.push('กรุณากรอกชื่อผู้ใช้งาน');
                }
                if (!this.password) {
                    this.errors.push('กรุณากรอกรหัสผ่าน.');
                }
                e.preventDefault();
            }
        }
    })
</script>
</body>
</html>


