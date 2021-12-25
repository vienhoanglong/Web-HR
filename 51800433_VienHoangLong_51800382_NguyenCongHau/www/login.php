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
    <div class="container">
        <form class="w-50 mx-auto mt-5 p-4 card form-login">
            <h3 class="mx-auto">ĐĂNG NHẬP</h3>
            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Tài khoản" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Mật khẩu" required>
                </div>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember">Remember me
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