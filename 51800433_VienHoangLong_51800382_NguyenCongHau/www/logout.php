<?php
ob_start();
session_start();
session_destroy();
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
    <title>Logout</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 mx-auto p-3 border rounded card">
                <h4>Đăng xuất thành công</h4>
                <p>Tài khoản của bạn đã được đăng xuất khỏi hệ thống.</p>
                <p>Nhấn <a href="login.php" class="text-primary">vào đây</a> để trở về trang đăng nhập, hoặc trang web sẽ tự động chuyển hướng sau <span class="text-danger">5</span> giây nữa.</p>
                <a class="btn btn-info" href="login.php">Đăng nhập</a>
                <?php
                header("refresh:5;url=login.php");
                ob_end_flush();
                exit();
                ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>