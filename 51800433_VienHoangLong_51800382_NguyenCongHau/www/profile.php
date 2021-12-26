<?php
session_start();
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
    <div class="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content">
            <!-- Navbar -->
            <?php include('includes/navbar.php'); ?>
            <!-- Page Content  -->
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between">
                    <h4 class="text-gray-800">Thông tin về bạn</h4>
                </div>
                <div class="row m-2">
                    <div class="col-xl-12 col-lg-9">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img class="img-profile-edit rounded-circle shadow" src="/PS1png.png" alt="">
                                    <label class="btn d-flex justify-content-center ">
                                        <span class="input-group-text">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                        <input type="file" class="upload-img" value="Upload Photo">
                                    </label>
                                    <h4>Viên Hoàng Long</h4>
                                </div>
                                <form>
                                    <div class="form-row m-2">
                                        <div class="col mr-4">
                                            <label>Mã nhân viên</label>
                                            <input type="text" class="form-control" placeholder="NV01" readonly>
                                        </div>
                                        <div class="col">
                                            <label>Username</label>
                                            <input type="text" class="form-control" placeholder="Vienhoanglong" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row m-2">
                                        <div class="col mr-4">
                                            <label>Chức vụ</label>
                                            <input type="text" class="form-control" placeholder="Trưởng phòng" readonly>
                                        </div>
                                        <div class="col">
                                            <label>Phòng ban</label>
                                            <input type="text" class="form-control" placeholder="Phòng CNTT" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row m-2">
                                        <label> Email</label>
                                        <input type="text" class="form-control" placeholder="vienhoanglong789@gmail.com">
                                    </div>
                                    <div class="form-row m-2">
                                        <label> Password</label>
                                        <input type="text" class="form-control" placeholder="********************">
                                    </div>
                                    <div class="form-row m-2">
                                        <div class="col  mr-4">
                                            <label>New Password</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label>Confirm Password</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="m-2 btn btn-lg br-color">Save changes</button>
                                </form>
                            </div>
                        </div>
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