<!DOCTYPE html>
<html>
<head>
    <?php require('./css.php') ?>
    <title>ผู้ใช้งาน</title>
    <?php
        $year = date('Y');
    ?>
</head>
<body>
<?= require('./navbar-left.php') ?>
<div class="content">
    <div class="container">
        <h3>Dashboard</h3>

        <h4>รายงานยอดขายประจำปี <?= $year; ?></h4>
        <canvas id="myChart"></canvas>

    </div>
</div>
<?php require('./script.php') ?>
<!-- End Script -->
<script>
    new Vue({
        el: '#app-products',
        data: {
            data: [],
        },
        created: function () {
            this.getReport();
        },
        methods: {
            getReport: function () {
                let url = '/api/dashboard.php?status=all-report';
                axios.get(url).then(response => {
                    const {data} = response.data;
                    this.data = data;

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
                            datasets: [{
                                label: '<?= $year; ?>',
                                data: this.data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                })
            },


        }
    })
</script>
</body>
</html>