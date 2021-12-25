<?php
ob_start();
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
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
    <title>Đăng nhập</title>
</head>

<body>
    <?php
    $error = [];
    $user = '';
    $pass = '';
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        if (empty($user)) {
            $error['user'] = 'Vui lòng nhập tài khoản đăng nhập!';
        } else if (empty($pass)) {
            $error['pass'] = 'Vui lòng nhập mật khẩu!';
        } else if (strlen($pass) < 6) {
            $error['pass'] = 'Mật khẩu phải có ít nhất 6 ký tự!';
        } else {
            $data = login($user, $pass);
            if ($data) {
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $data['fullname'];

                header('Location: index.php');
                ob_end_flush();
                exit();
            } else {
                $error['pass'] = 'Tài khoản hoặc mật khẩu không đúng!';
            }
        }
    }
    ?>
    <div class="container">
        <form class="w-50 mx-auto mt-5 p-4 card form-login" action="" method="Post">
            <h3 class="mx-auto">ĐĂNG NHẬP</h3>
            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Tài khoản" id="user" name="user">
                </div>
                <span class="text-danger font-weight-bold">
                    <?php echo (isset($error['user'])) ? $error['user'] : '' ?>
                </span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Mật khẩu" id="pass" name="pass">
                </div>
                <span class="text-danger font-weight-bold"><?php echo (isset($error['pass'])) ? $error['pass'] : '' ?></span>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" <?= isset($_POST['remember']) ? 'checked' : '' ?> type="checkbox" type="checkbox" name="remember" id="remember">Remember me
                </label>
            </div>
            <button type="submit" class="btn br-color">ĐĂNG NHẬP</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>