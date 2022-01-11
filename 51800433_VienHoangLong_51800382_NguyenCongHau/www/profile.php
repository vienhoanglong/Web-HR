<?php
ob_start();
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/style.css">
    <title>Trang Cá Nhân</title>
</head>

<body>
    <?php
    require_once('db.php');
    $title_page = 'profile';
    $user = $_SESSION['user'];
    $info = get_information($user);
    $info = $info->fetch_assoc();
    $error = [];
    $pass_old = '';
    $user_new = '';
    $pass_confirm = '';
    if (isset($_POST['pass_old']) && isset($_POST['pass_new']) && isset($_POST['pass_confirm'])) {
        $pass = $_POST['pass_old'];
        $newpass = $_POST['pass_new'];
        $confirm = $_POST['pass_confirm'];
        $user = $_SESSION['user'];
        if (empty($pass)) {
            $error['pass-old'] = 'Vui lòng nhập mật khẩu hiện tại!';
        } else if (strlen($pass) < 6) {
            $error['pass-old'] = 'Mật khẩu phải có từ 6 kí tự trở lên!';
        } else if (empty($newpass)) {
            $error['pass-new'] = 'Vui lòng nhập mật khẩu mới!';
        } else if (strlen($newpass) < 6) {
            $error['pass-new'] = 'Mật khẩu phải có từ 6 kí tự trở lên!';
        } else if ($newpass != $confirm) {
            $error['pass-confim'] = 'Mật khẩu không khớp!';
        } else {
            $result = change_new_password($user, $pass, $newpass);
            if ($result['code'] == 1) {
                $error['err'] = 'Thay đổi mật khẩu không thành công!';
            } else if ($result['code'] == 2) {
                $error['err'] = 'Mật khẩu hiện tại không đúng!';
            } else {
                session_destroy();
                echo '<div class="col-md-6 mt-5 mx-auto p-3 border rounded card">
                <h4>Thay đổi mật khẩu thành công</h4>
                <p>Tài khoản của bạn đã được đăng xuất khỏi hệ thống.</p>
                <p>Nhấn <a href="login.php" class="text-primary">vào đây</a> để trở về trang đăng nhập, hoặc trang web sẽ tự động chuyển hướng sau <span class="text-danger">5</span> giây nữa.</p>
                <a class="btn btn-info" href="login.php">Đăng nhập</a>
                </div>';
                header("refresh:5;url=login.php");
                ob_end_flush();
                exit();
            }
        }
    }
    //Upload avatar
    $uploadDir = 'images/';
    $uploadedFile = '';
    if (!empty($_FILES['imgInp']['name'])) {
        $fileName = basename($_FILES['imgInp']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpeg', 'png', 'jpg');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['imgInp']['tmp_name'], $targetFilePath)) {
                $uploadedFile = $fileName;
                $result = upload_img_profile($user, $fileName);
                if ($result['code'] == 2) {
                    die("error");
                }
            } else {
                die("error");
            }
        } else {
            die("error");
        }
    }
    ?>
    <div class="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content">
            <!-- Navbar -->
            <?php include('includes/navbar.php'); ?>
            <!-- Page Content  -->
            <div class="container">
                <div class="d-sm-flex justify-content-between">
                    <h4 class="text-gray-800">Thông tin về bạn</h4>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-9">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-profile-edit rounded-circle shadow" src="/images/<?= $info['avatar'] ?>" alt="">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn">
                                        <span class="input-group-text click-update-image">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="text-center mb-4">
                                    <h4 class="text-primary"><?= $info['fullname'] ?></h4>
                                </div>
                                <div class="form-row m-2">
                                    <div class="col mr-4">
                                        <label>Mã nhân viên</label>
                                        <input type="text" class="form-control" value="<?= $info['id'] ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="<?= $info['username'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row m-2">
                                    <div class="col mr-4">
                                        <label>Chức vụ</label>
                                        <input type="text" class="form-control" placeholder="Admin" value="<?= $info['position'] ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Phòng ban</label>
                                        <input type="text" class="form-control" placeholder="Admin" value="<?= $info['department'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row m-2">
                                    <label> Email</label>
                                    <input type="text" class="form-control" value="<?= $info['email'] ?>" readonly>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data" novalidate>
                                    <div class="form-row m-2">
                                        <label> Password</label>
                                        <input type="password" class="form-control" name="pass_old" id="pass_old">
                                        <span class="text-danger font-weight-bold">
                                            <?php echo (isset($error['pass-old'])) ? $error['pass-old'] : '' ?>
                                        </span>
                                    </div>
                                    <div class="form-row m-2">
                                        <div class="col  mr-4">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="pass_new" id="pass_new">
                                            <span class="text-danger font-weight-bold">
                                                <?php echo (isset($error['pass-new'])) ? $error['pass-new'] : '' ?>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="pass_confirm" id="pass_confirm">
                                            <span class="text-danger font-weight-bold">
                                                <?php echo (isset($error['pass-confirm'])) ? $error['pass-confirm'] : '' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit" class="m-2 btn br-color">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="upload-profile" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Cập nhật ảnh đại diện</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <img id="img_preview" src="#" alt="Your image profile" class="img-profile-edit rounded-circle shadow">
                        </div>
                        <form runat="server" id="form-upload-img" method="post" enctype="multipart/form-data">
                            <div class="form-group text-center">
                                <input name="imgInp" type="file" id="imgInp" accept="image/*">
                            </div>
                            <div class="form-group pull-right mt-5">
                                <input type='button' class='btn btn-info' value='Save' id='btn_upload'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>