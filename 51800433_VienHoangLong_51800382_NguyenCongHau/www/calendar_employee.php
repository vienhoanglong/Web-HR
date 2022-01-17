<?php
session_start();
require_once('db.php');
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['role'] != 2) {
    header('Location: index.php');
    exit();
}
$title_page = 'calendar_employee';
$user = $_SESSION['user'];
$date = 12;
$info = get_information($user);
$info = $info->fetch_assoc();
$rest_dayoff = calendar_rest($user);
$calendar_result = load_result_calendar_employee($user);
//Load so ngay nghi
$day_calendar = get_dayoff($user);
$er_calendar = array(
    'error' => 0
);
if (isset($_POST['username']) && isset($_POST['ngayBatDau']) && isset($_POST['ngayKetThuc']) && isset($_POST['liDo']) && isset($_POST['ngayConLai'])) {
    $username = $_POST['username'];
    $ngayBatDau = $_POST['ngayBatDau'];
    $ngayKetThuc = $_POST['ngayKetThuc'];
    $liDo = $_POST['liDo'];
    $ngayConLai = $_POST['ngayConLai'];
    $info_user = (get_information($username));
    $info_user = $info_user->fetch_assoc();
    $department = $info_user['department'];
    $postion = $info_user['position'];
    $result = create_calendar($username, $postion, $department, $ngayBatDau, $ngayKetThuc, $liDo, $ngayConLai);
    if ($result['code'] == 1) {
        $er_calendar['error'] = 1;
        $er_calendar['dayoff'] = "Số ngày nghỉ của bạn đã vượt mức";
    }
    if ($result['code'] == 2) {
        $er_calendar['error'] = 1;
        $er_calendar['command'] = 'Tạo đơn xin nghỉ phép không thành công';
    }
    die(json_encode($er_calendar));
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
    <title>Ngày nghỉ phép</title>
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
                    <div class="row mr-2 mt-4">
                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card shadow-sm h-70">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
                                                Tổng ngày nghỉ</div>
                                            <h5 class="mb-0 font-weight-bold text-gray"><?= $day_calendar['ngayDaNghi'] + $day_calendar['ngayConLai'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card shadow-sm h-70">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
                                                Ngày đã nghỉ</div>
                                            <h5 class="mb-0 font-weight-bold text-gray"><?= $day_calendar['ngayDaNghi'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card shadow-sm h-70">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
                                                Ngày còn lại</div>
                                            <h5 class="mb-0 font-weight-bold text-gray"><?= $day_calendar['ngayConLai'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Bảng danh sách kết quả cầu nghỉ phép của bạn</h4>
                            <h6 class="font-weight-bold text-danger">*Note: Tổng ngày nghỉ trong năm là nhân viên 12 ngày, trưởng phòng 15 ngày</h6>
                            <div>
                                <button class="create-calender-nv btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Xin nghỉ phép</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tài khoản</th>
                                            <th>Yêu cầu</th>
                                            <th>Thời gian nghỉ</th>
                                            <th>Thời gian yêu cầu</th>
                                            <th>Lí do</th>
                                            <th>Phê duyệt</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($calendar_result)) { ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $row['username'] ?></td>
                                                <td><?= check_dayoff($row['ngayBatDau'], $row['ngayKetThuc']) ?> ngày</td>
                                                <td><?= date('d/m/Y', strtotime($row['ngayBatDau'])) . ' - ' . date('d/m/Y', strtotime($row['ngayKetThuc'])) ?></td>
                                                <td><?= $row['thoiGianTao'] ?></td>
                                                <td><?= $row['liDo'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['trangThai'] == 'Chờ duyệt') {
                                                        echo '<span class="text  alert-warning font-weight-bold">Chờ duyệt</span>';
                                                    } elseif ($row['trangThai'] == 'Đã duyệt') {
                                                        echo '<span class="text  alert-success font-weight-bold">Đã duyệt</span>';
                                                    } else {
                                                        echo '<span class="text  alert-danger font-weight-bold">Không duyệt</span>';
                                                    }
                                                    ?>

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
        <!-- Dialog create calendar -->
        <div id="create-calendar-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xin nghỉ phép</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="row">
                                <div class="col">
                                    <label>Mã nhân viên</label>
                                    <input name="id_nv_create" class="form-control" type="text" id="id_nv_create" value="<?= $info['id'] ?>" readonly>
                                </div>
                                <input name="user_nv_create" class="form-control" type="hidden" id="user_nv_create" value="<?= $info['username'] ?>" readonly>
                                <div class="col">
                                    <label>Họ và tên</label>
                                    <input name="name_tp_create" class="form-control" type="text" id="name_nv_create" value="<?= $info['fullname'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Chức vụ</label>
                                    <input name="position_nv_create" class="form-control" type="text" id="position_nv_create" value="<?= $info['position'] ?>" readonly>
                                </div>
                                <div class="col">
                                    <label>Phòng ban</label>
                                    <input name="department_nv_create" class="form-control" type="text" id="department_nv_create" value="<?= $info['department'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Số ngày nghỉ còn lại</label>
                                    <input name="rest_day_nv" class="form-control" type="text" id="rest_day_nv" value="<?= $rest_dayoff ?>" readonly>
                                </div>
                                <div class="col">
                                    <label>Đã sử dụng</label>
                                    <input name="used_day" class="form-control" type="text" id="used_day" value="<?= $date - $rest_dayoff ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 class="font-weight-bold">Yêu cầu xin nghỉ</h5>
                        </div>
                        <div class="form-group">
                            <label>Từ ngày</label>
                            <input name="from_date_nv" class="form-control" type="date" id="from_date_nv">
                            <span id="err-from-date-nv" class="text-danger font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Đến ngày</label>
                            <input name="to_date_nv" class="form-control" type="date" id="to_date_nv">
                            <span id="err-to-date-nv" class="text-danger font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Lí do</label>
                            <textarea id="reason_nv" name="reason_nv" rows="4" class="form-control" placeholder="Thêm lí do nghỉ"></textarea>
                            <span id="err-reason-nv" class="text-danger font-weight-bold"></span>
                        </div>
                    </div>
                    <div class="modal-footer pull-left">
                        <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn br-color" id="btn-create-calender-nv">Submit</button>
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