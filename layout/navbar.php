<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow fixed-top " style="z-index: 1;background: white;height: 60px;">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="/">
            <img src="../assets/img/logo.jpg" class="img-fluid" style="width:100px;height:60px; object-fit: contain;"/>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#shop">สินค้าของเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">ติดต่อเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">ที่ตั้งเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#how-to-order">วิธีการสั่งซื้อ</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">

                <a class="nav-icon position-relative text-decoration-none" href="cart.php">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span id="cart-number" class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">0</span>
                </a>
                <a class="nav-icon position-relative text-decoration-none" href="#" id="usernonlogin">
                    <i class="fa fa-fw fa-user text-dark mr-1"></i>
                </a>
                <a class="dropdown" id="dropdownUser2">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong id="my-profile"></strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="profile.php">ข้อมูลส่วนตัว</a></li>
                        <li><a class="dropdown-item" href="order.php">รายการสั่งซื้อของฉัน</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                    </ul>
                </a>
            </div>
        </div>

    </div>
</nav>
<!-- Close Header -->
