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
        <h3>Dashboard</h3>
    </div>
</div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-products',
        data: {
            search: null,
            products: [],
        },
        created: function () {
            this.getProducts();
        },
        methods: {
            //get category all
            getProducts: function () {
                let url = '/api/products.php?status=find-all';
                if (this.search != null) {
                    url += '&search=' + this.search;
                }
                axios.get(url).then(response => {
                    const {data, status, message} = response.data;
                    this.products = data;
                })
            },
            //set form update
            edit: function (id) {
                location.href = '/admin/product-form.php?id=' + id;
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