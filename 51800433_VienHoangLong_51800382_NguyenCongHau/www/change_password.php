<?php
ob_start();
session_start();
if (!isset($_SESSION['user']) && $_SESSION['activated'] == 1) {
    header('Location: login.php');
    exit();
}
require_once('db.php');
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
    <title>Thay đổi mật khẩu</title>
</head>

<body>
    <?php
    $error = [];
    $pass = '';
    $pass_confirm = '';
    if (isset($_POST['pass']) && isset($_POST['pass_confirm'])) {
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass_confirm'];
        $user = $_SESSION['user'];
        if (empty($pass)) {
            $error['pass'] = 'Vui lòng nhập mật khẩu!';
        } else if (strlen($pass) < 6) {
            $error['pass'] = 'Mật khẩu phải có ít nhất 6 ký tự!';
        } else if ($pass != $pass_confirm) {
            $error['pass_confirm'] = 'Mật khẩu không khớp!';
        } else {
            $result = change_password($user, $pass);
            if ($result['code'] == 0) {
                $_SESSION['activated'] = 1;
                header('Location: login.php');
                ob_end_flush();
                exit();
            }
        }
    }
    ?>
    <div class="container">
        <form action="" method="post" class="col-md-6 mt-5 mx-auto p-3 border rounded card form-login" novalidate>
            <h3 class="mx-auto">THAY ĐỔI MẬT KHẨU</h3>
            <div class="form-group">
                <label>New password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Mật khẩu" id="pass" name="pass">
                </div>
                <span class="text-danger font-weight-bold">
                    <?php echo (isset($error['pass'])) ? $error['pass'] : '' ?>
                </span>
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" id="pass_confirm" name="pass_confirm">
                </div>
                <span class="text-danger font-weight-bold">
                    <?php echo (isset($error['pass_confirm'])) ? $error['pass_confirm'] : '' ?>
                </span>
            </div>
            <button type="submit" class="btn br-color">THAY ĐỔI MẬT KHẨU</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>