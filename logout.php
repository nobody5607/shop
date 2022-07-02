<!DOCTYPE html>
<html>
<head>
    <?php require('./layout/head.php') ?>
    <title>Login Page</title>
</head>
<body>

<div id="app-login" class="row d-flex justify-content-center">
</div>
<!-- Start Footer -->
<?php require('./layout/footer.php') ?>
<!-- End Footer -->

<?php require('./layout/script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-login',
        data: {
            errors: [],
            username: 'admin',
            password: '123456'
        },
        created(){
            localStorage.clear();
            location.href = 'index.php';
        },
        methods: {

        }
    })
</script>
</body>
</html>


