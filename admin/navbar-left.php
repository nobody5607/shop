<?php
    $active = isset($_GET['active']) ? $_GET['active']: '';
?>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="/admin/dashboard.php?active=dashboard" class="nav-link link-dark <?= $active == 'dashboard' ? 'active' : ''?>" >
                <i class="bi bi-speedometer"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/orders.php?active=orders" class="nav-link link-dark <?= $active == 'orders' ? 'active' : ''?>">
                <i class="bi bi-bag-check-fill"></i>
                รายการสั่งซื้อ
            </a>
        </li>
        <li>
            <a href="/admin/products.php?active=products" class="nav-link link-dark <?= $active == 'products' ? 'active' : ''?>">
                <i class="bi bi-shop"></i>
                สินค้า
            </a>
        </li>
        <li>
            <a href="/admin/users.php?active=users" class="nav-link link-dark <?= $active == 'users' ? 'active' : ''?>">
                <i class="bi bi-people"></i>
                ผู้ใช้
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>