<?php
session_start();
require_once('db.php');
$departments = get_department();
$d_name = get_name_department();
$errors = array(
    'error' => 0
);
$name = '';
$address = '';
$desc = '';
if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['desc'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];
    $result = create_department($name, $address, $desc);
    if ($result['code'] == 1) {
        $errors['error'] = 1;
        $errors['department'] = 'Phòng ban này đã tồn tại';
    }
    if ($result['code'] == 2) {
        $errors['error'] = 1;
        $errors['comand'] = 'Không thể tạo phòng ban!';
    }
    die(json_encode($errors));
}
//Hiển thị dữ liệu department lên modal
if (isset($_POST['checking_load'])) {
    $ud_department_id = $_POST['ud_department_id'];
    $data = [];
    $count = count_employee_department($ud_department_id);
    array_push($data, $count);
    $result = get_information_load_department($ud_department_id);
    if (mysqli_fetch_assoc($result) > 0) {
        foreach ($result as $row) {
            array_push($data, $row);
            header('Content-Type: application/json');
            die(json_encode($data));
        }
    }
}
//Update department
$er_ud = array(
    'error' => 0
);
if (isset($_POST['ud_name']) && isset($_POST['ud_address']) && isset($_POST['ud_desc']) && isset($_POST['ud_id_department'])) {
    $ud_name = $_POST['ud_name'];
    $ud_address = $_POST['ud_address'];
    $ud_desc = $_POST['ud_desc'];
    $id_department = $_POST['ud_id_department'];
    $result = update_department($ud_name, $ud_address, $ud_desc, $id_department);
    if ($result['code'] == 1) {
        $er_update['error'] = 1;
        $er_update['department'] = 'Phòng ban này đã có trong công ty!';
    }
    if ($result['code'] == 2) {
        $er_update['error'] = 1;
        $er_update['department'] = 'Cập nhật phòng ban không thành công!';
    }
    die(json_encode($er_ud));
}
//Load dữ liệu lên modal bổ nhiệm
if (isset($_POST['checking_promote'])) {
    $id_department_promote = $_POST['id_department_promote'];
    $result = load_employee_department($id_department_promote);
    header('Content-Type: application/json');
    die(json_encode($result));
}
//Bổ nhiệm trưởng phòng
$er_promote = array(
    'error' => 0
);
if (isset($_POST['department_promote']) && isset($_POST['user_promote']) && $_POST['position_promote']) {
    $department_promote = $_POST['department_promote'];
    $user_promote = $_POST['user_promote'];
    $position_promote = $_POST['position_promote'];
    $result = promote_department($department_promote, $user_promote, $position_promote);
    if ($result['code'] == 3) {
        $er_promote['error'] = 1;
        $er_promote['department'] = 'Phòng ban này đã có trưởng phòng!';
    }
    if ($result['code'] == 2) {
        $er_promote['error'] = 1;
        $er_promote['department'] = 'Bổ nhiệm/bãi nhiệm trưởng phòng không thành công!';
    }
    if ($result['code'] == 1) {
        $er_promote['error'] = 1;
        $er_promote['department'] = 'Hiện đã là nhân viên!';
    }
    die(json_encode($er_promote));
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
    <title>Phòng ban</title>
</head>

<body>
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
                            <h4 class="font-weight-bold text-primary">Bảng Danh Sách Phòng Ban</h4>
                            <div class="row pl-3">
                                <div class="click-create-department mr-2">
                                    <button class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Tạo phòng ban</button>

                                </div>
                                <div class="click-create-promote mr-2">
                                    <button class="btn btn-primary"><i class="fa fa-star" aria-hidden="true"></i>
                                        Bổ nhiệm</button>
                                </div>
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
                                            <th>Mã phòng</th>
                                            <th>Số phòng</th>
                                            <th>Trưởng phòng</th>
                                            <th>Phòng Ban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($departments)) { ?>
                                        <tbody>
                                            <tr>
                                                <td id="id-department"><?= $row['idDepartment'] ?></td>
                                                <td><?= $row['addressDepartment'] ?></td>
                                                <td><?= $row['manager'] ?></td>
                                                <td> <a href="#" class="font-weight-bold click-details-department"><?= $row['nameDepartment'] ?></a></td>
                                                <td>
                                                    <a class="btn btn-primary btn-icon-split click-update-department">
                                                        <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                        <span>Edit</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog create department-->
        <div id="create-department" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Thêm phòng ban mới</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" novalidate>
                            <div class="form-group">
                                <label>Số phòng</label>
                                <input name="address_room" class="form-control" type="text" placeholder="Số phòng" id="address_room">
                                <span id="er-address" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Tên phòng ban</label>
                                <input name="name_room" class="form-control" type="text" placeholder="Tên phòng ban" id="name_room">
                                <span id="er-name" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="desc_room" name="desc_room" rows="4" class="form-control" placeholder="Mô tả"></textarea>
                                <span id="er-desc" class="text-danger font-weight-bold"></span>
                            </div>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                        </form>
                    </div>
                    <div class="modal-footer pull-left">
                        <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn br-color" id="btn-create-department">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog create promote -->
        <div id="create-promote" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bổ nhiệm nhân viên</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Phòng ban</label>
                            <select class="form-control" id="department_promote" name="department_promote">
                                <?php
                                foreach ($d_name as $key => $value) :
                                    echo '<option value =' . $value['idDepartment'] . '>' . $value['nameDepartment'] . '</option>';
                                endforeach;
                                ?>
                            </select>
                            <a class="btn br-color btn-icon-split btn-details-promote mt-2">
                                <span class="icon text-white-50"><i class="fa fa-chevron-circle-down"></i></span>
                                <span>Chọn</span>
                            </a>
                        </div>
                        <div class="form-group d-none" id="details-promote">
                            <h6 class="mb-2">Thông tin chi tiết nhân viên bổ nhiệm</h6>
                            <div class="form-group">
                                <label>Nhân viên</label>
                                <select class="form-control" id="user_promote" name="user_promote">

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <select class="form-control" id="position_promote" name="position_promote">
                                    <option value="Employee">Nhân viên</option>
                                    <option value="Manager">Trưởng phòng</option>
                                </select>
                            </div>
                        </div>
                        <span class="alert-danger">

                        </span>
                        <span class="alert-success">

                        </span>
                    </div>
                    <div class="modal-footer pull-left d-none" id="footer-promote">
                        <button type="button" class="btn br-color" data-dismiss="modal" id="close-promote">Cancel</button>
                        <button type="button" class="btn br-color" id="btn-department-promote">Promote</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog update department -->
        <div id="update-department" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Chỉnh sửa phòng ban</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="ud_department_id" id="ud_department_id">
                            </div>
                            <div class="form-group">
                                <label>Số phòng</label>
                                <input name="num-room" class="form-control" type="text" id="update_address">
                                <span id="ud-err-address" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Tên phòng ban</label>
                                <input name="update_name" class="form-control" type="text" id="update_name">
                                <span id="ud-err-name" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="update_desc" name="update_desc" rows="6" class="form-control"></textarea>
                                <span id="ud-err-desc" class="text-danger font-weight-bold"></span>
                            </div>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn br-color" id="btn-update-department">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Dialog details department-->
        <div id="details-department" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Chi tiết phòng ban</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="fomr-group">
                                <input type="hidden" name="load_department_id" id="load_department_id">
                            </div>
                            <div class="form-group">
                                <label>Số phòng</label>
                                <input name="load_address" class="form-control" type="text" id="load_address" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tên phòng ban</label>
                                <input name="load_name" class="form-control" type="text" id="load_name" readonly>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Trưởng phòng</label>
                                        <input name="load_dpm_manager" class="form-control" type="text" id="load_dpm_manager" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Số lượng nhân viên</label>
                                        <input name="load_quantity" class="form-control" type="text" id="load_quantity" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="load_desc" name="load_desc" rows="6" class="form-control" readonly></textarea>
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