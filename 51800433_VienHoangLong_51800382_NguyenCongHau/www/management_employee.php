<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
require_once('db.php');
$users = get_employee();
$errors = array(
    'error' => 0
);
$fullname = '';
$username = '';
$position = '';
$department = '';
$email = '';

if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['position']) && isset($_POST['department']) && isset($_POST['email'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $result = create_employee($username, $fullname, $email, $department, $position);
    if ($result['code'] == 3) {
        $errors['error'] = 1;
        $errors['position'] = "Hiện phòng ban này đã có trưởng phòng";
    }
    if ($result['code'] == 1) {
        $errors['error'] = 1;
        $errors['username'] = 'Tài khoản nhân viên đã tồn tại';
    }
    if ($result['code'] == 2) {
        $errors['error'] = 1;
        $errors['comand'] = 'Lệnh không được thực hiện!';
    }
    if ($result['code'] == 4) {
        $errors['error'] = 1;
        $errors['email'] = 'Email đã tồn tại!';
    }
    die(json_encode($errors));
}
//Delete employee
$er_delete = array(
    'error' => 0
);
if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    $result = delete_employee($employee_id);
    if ($result['code'] == 1) {
        $er_delete['error'] = 1;
        $er_delete = 'Xóa không thành công';
    }
    if ($result['code'] == 0) {
        $er_delete['error'] = 0;
        $er_delete = ' Xóa thành công';
    }
    die(json_encode($er_delete));
}

//Hiển thị dữ liệu employee lên modal
if (isset($_POST['checking_edit'])) {
    $ud_employee_id = $_POST['ud_employee_id'];
    $data = [];
    $result = get_information_load_employee($ud_employee_id);
    if (mysqli_fetch_assoc($result) > 0) {
        foreach ($result as $row) {
            array_push($data, $row);
            header('Content-Type: application/json');
            die(json_encode($data));
        }
    }
}
//Update employee
$er_update = array(
    'error' => 0
);
if (isset($_POST['ud_employee_fullname']) && isset($_POST['ud_employee_username']) && isset($_POST['ud_employee_email']) && isset($_POST['ud_employee_id'])) {
    $ud_employee_fullname = $_POST['ud_employee_fullname'];
    $ud_employee_username = $_POST['ud_employee_username'];
    $ud_employee_email = $_POST['ud_employee_email'];
    $ud_employee_id = $_POST['ud_employee_id'];
    $result = update_employee($ud_employee_fullname, $ud_employee_username, $ud_employee_email, $ud_employee_id);
    if ($result['code'] == 0) {
        $er_update['error'] = 0;
        $er_update['success'] = 'Cập nhật nhân viên thành công!';
    }
    if ($result['code'] == 1) {
        $er_update['error'] = 1;
        $er_update['comand'] = 'Cập nhật nhân viên không thành công!';
    }
    die(json_encode($er_update));
}
//Reset password default 
$er_reset = array(
    'error' => 0
);
if (isset($_POST['rs_employee_id'])) {
    $rs_employee_id = $_POST['rs_employee_id'];
    $result = reset_password_default($rs_employee_id);
    if ($result['code'] == 0) {
        $er_reset['error'] = 0;
        $er_reset = 'Reset mật khẩu về mặc định thành công!';
    }
    if ($result['code'] == 1) {
        $er_reset['error'] = 1;
        $er_reset = 'Reset mật khẩu về mặc định không thành công!';
    }
    die(json_encode($er_reset));
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
    <title>Quản lý nhân viên</title>
</head>

<body>
    <?php
    $d_name = get_name_department();
    // print_r($d_name);
    ?>
    <div class="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content">
            <!-- Navbar -->
            <?php include('includes/navbar.php'); ?>
            <!-- Page Content  -->
            <div class="container-fluid">
                <div class="col-xl-12 col-lg-9">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-header py-3">
                            <h4 class="font-weight-bold text-primary">Bảng Danh Sách Nhân Viên</h4>
                            <div class="click-create-employee">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Create Employee</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-outline mb-2">
                                <input type="search" class="form-control" placeholder="Search..." />

                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã nhân viên</th>
                                            <th>Họ Tên</th>
                                            <th>Chức vụ</th>
                                            <th>Phòng Ban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($users)) { ?>

                                        <tbody>
                                            <tr>
                                                <td id="id-employee"><?= $row['id'] ?></td>
                                                <td><a href="#" class="font-weight-bold click-details-employee"><?= $row['fullname'] ?></a></td>
                                                <td><?= $row['position'] ?></td>
                                                <td><?= $row['department'] ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-icon-split click-update-employee">
                                                        <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                        <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                        <span>Delete</span>
                                                    </a>
                                                    <a class="btn btn-info btn-icon-split click-reset-password">
                                                        <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                        <span>Pass</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Trước</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog create employee-->
        <div id="create-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nhân viên mới</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="fulname">Họ và tên</label>
                                <input name="fullname" class="form-control" type="text" placeholder="Full name" id="fullname">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                                <span id="er-username" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <label for="position">Chức vụ</label>
                                </div>
                                <select class="form-control" name="position" id="position">
                                    <option value="Employee">Nhân viên</option>
                                    <option value="Manager">Trưởng phòng</option>
                                </select>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="department">Phòng ban</label>
                                <select class="form-control" name="department" id="department">
                                    <?php
                                    foreach ($d_name as $key => $value) :
                                        echo '<option value =' . $value['idDepartment'] . '>' . $value['nameDepartment'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                                <span id="er-department" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" class="form-control" type="text" placeholder="email123@example.com" id="email">
                                <span id="er-email" class="text-danger font-weight-bold"></span>
                            </div>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" id="btn-create-employee" class="btn br-color">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog update employee -->
        <div id="update-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Chỉnh sửa nhân viên mới</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="fomr-group">
                                <input type="hidden" name="ud_employee_id" id="ud_employee_id">
                            </div>
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input name="fullname" id="update_fullname" class="form-control" type="text">
                                <span id="ud-err-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" id="update_user" class="form-control" type="text">
                                <span id="ud-err-username" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <input name="positon" id="update_position" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Phòng ban</label>
                                <input name="department" id="update_department" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" type="text" id="update_email">
                                <span id="ud-err-email" class="text-danger font-weight-bold"></span>
                            </div>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                            <button type="button" id="btn-update-employee" class="btn br-color">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Dialog delete employee -->
        <div id="delete-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Xóa nhân viên</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="" method="">
                        <div class="modal-body">
                            <input type="hidden" name="employee_id" id="employee_id">
                            <p>Bạn có chắc rằng muốn xóa nhân viên này ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="btn-delete-employee">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Dialog re-password employee -->
        <div id="re-password-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Reset mật khẩu nhân viên</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="rs_employee_id" id="rs_employee_id">
                        <p>Bạn có chắc rằng muốn reset mật khẩu về mặc định ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="btn-reset-password">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="details-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Thông tin chi tiết nhân viên</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <div class="fomr-group">
                                <input type="hidden" name="load_employee_id" id="load_employee_id">
                            </div>
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input name="fullname" id="load_fullname" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" id="load_user" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <input name="username" id="load_position" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Phòng ban</label>
                                <input name="department" id="load_department" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" type="text" id="load_email" readonly>
                            </div>
                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
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