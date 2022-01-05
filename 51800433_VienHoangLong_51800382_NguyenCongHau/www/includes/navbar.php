<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('db.php');
$user = $_SESSION['user'];
$info = get_information($user);
$info = $info->fetch_assoc();
?>
<nav class="navbar navbar-inverse navbar-light bg-white">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" id="sidebar-collapse" class="btn navbar-btn">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn text-orange" type="button">
                        <i class="fa fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
        <ul class="nav navbar-nav navbar-right dropdown dropdown-user">
            <li class="nav-item item-username"><a href="#" class="font-weight-bold">Tài khoản - <?= $_SESSION['name'] ?></a></li>
            <div class="dropdown-content-user shadow-sm mt-3">
                <a class="click-to-profile" href="../profile.php">Thông tin cá nhân</a>
                <a class="click-to-logout" href="../logout.php">Đăng xuất</a>
            </div>
            <img class="img-profile rounded-circle" src="/images/<?= $info['avatar'] ?>">
        </ul>
    </div>
</nav>