<?php
session_start();
require_once('db.php');
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['role'] != 1) {
    header('Location: index.php');
    exit();
}
//Phân trang
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$num_per_page = 05;
$start_from = ($page - 1) * 05;
$title_page = 'calendar_manager';
$user = $_SESSION['user'];
$department = $_SESSION['department'];
$date = 15;
$info = get_information($user);
$info = $info->fetch_assoc();
$rest_dayoff = calendar_rest($user);
$calendar = load_calendar_employee($start_from, $num_per_page, $department);
$calendar_result = load_result_calendar($user, $start_from, $num_per_page);
//load phân trang
$num_row = get_calendar_employee();
$num_row_calendar = (mysqli_num_rows($num_row));
$total_page = ceil($num_row_calendar / $num_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
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
//Hiển thị chi tiết đơn xin nghỉ phép của một nhân viên
if (isset($_POST['checking_calendarnv'])) {
    $idnv_calendar = $_POST['idnv_calendar'];
    $data = [];
    $username = load_calendar_byuser($idnv_calendar);
    $rest_day = load_accept_calendar();
    array_push($data, $rest_day);
    $temp = get_information($username);
    $result1 = $temp->fetch_assoc();
    array_push($data, $result1);
    $result = load_calendar_byid($idnv_calendar);
    if (mysqli_fetch_assoc($result) > 0) {
        foreach ($result as $row) {
            array_push($data, $row);
            header('Content-Type: application/json');
            die(json_encode($data));
        }
    }
}
//Không duyệt đơn xin nghỉ
$er_cancel_nv = array(
    'error' => 0
);
if (isset($_POST['checking_nv_cancel'])) {
    $idnv_calendar = $_POST['idnv_calendar'];
    $result = update_status_cancel_calendar($idnv_calendar);
    if ($result['code'] == 0) {
        $er_cancel_nv['error'] = 0;
        $er_cancel_nv = 'Không duyệt đơn thành công!';
    }
    if ($result['code'] == 2) {
        $er_cancel_nv['error'] = 1;
        $er_cancel_nv = 'Không duyệt đơn không thành công!';
    }
    die(json_encode($er_cancel_nv));
}
//Duyệt đơn xin nghỉ
$er_accept_nv = array(
    'error' => 0
);
if (isset($_POST['checking_nv_accept'])) {
    $idnv_calendar = $_POST['idnv_calendar'];
    $calendar = load_calendar_byid($idnv_calendar);
    $calendar = $calendar->fetch_assoc();
    $a = $calendar['ngayKetThuc'];
    $b = $calendar['ngayBatDau'];
    $user = $calendar['username'];
    $ngayBatDau = date("d-m-Y", strtotime($a));
    $ngayKetThuc = date("d-m-Y", strtotime($b));
    $dayoff = check_dayoff($ngayKetThuc, $ngayBatDau);
    $result = update_status_accept_calendar($idnv_calendar, $user, $dayoff);
    if ($result['code'] == 0) {
        $er_accept_nv['error'] = 0;
        $er_accept_nv = 'Phê duyệt đơn thành công!';
    }
    if ($result['code'] == 2) {
        $er_accept_nv['error'] = 1;
        $er_accept_nv = 'Phê duyệt đơn không thành công!';
    }
    die(json_encode($er_accept_nv));
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
                            <h4 class="font-weight-bold text-primary">Bảng Danh Sách Yêu Cầu Xin Nghỉ Phép</h4>
                            <h6 class="font-weight-bold text-danger">*Note: Tổng ngày nghỉ trong năm là nhân viên 12 ngày, trưởng phòng 15 ngày</h6>
                            <div>
                                <button class="create-calender-tp btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Xin nghỉ phép</button>
                                <button onclick="toggleResult()" class="btn btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>
                                    Kết quả</button>
                            </div>
                        </div>
                        <!-- Kết quả nghỉ phép -->
                        <div class="card-body" id="result_calendar_mn">
                            <h5 class="text text-success">Bảng danh sách kết quả cầu nghỉ phép của bạn</h5>
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
                        <!-- Danh sách yêu cầu nghỉ phép -->
                        <div class="card-body">
                            <h5 class="text text-primary">Bảng danh sách yêu cầu nghỉ phép</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="table-calendar" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã nghỉ phép</th>
                                            <th>Nhân viên</th>
                                            <th>Yêu cầu</th>
                                            <th>Thời gian</th>
                                            <th>Lí do</th>
                                            <th>Phê duyệt</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($calendar)) { ?>
                                        <tbody>
                                            <tr>
                                                <td id="id_calendar_manager"><?= $row['id'] ?></td>
                                                <td><?= $row['username'] ?></td>
                                                <td><?= check_dayoff($row['ngayBatDau'], $row['ngayKetThuc']) ?> ngày</td>
                                                <td><?= date('d/m/Y', strtotime($row['ngayBatDau'])) . '-' . date('d/m/Y', strtotime($row['ngayKetThuc'])) ?></td>
                                                <td>
                                                    <a class="btn click-detail-calender-nv text-primary">Chi tiết<a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['trangThai'] == 'Chờ duyệt') {
                                                        echo '<a class="btn btn-success btn-icon-split click-accept-calender-nv">
                                                    <span class="icon text-white-100"><i class="fa fa-check"></i></span>
                                                    </a>
                                                    <a class="btn btn-danger btn-icon-split click-cancel-calender-nv">
                                                        <span class="icon text-white-100"><i class="fa fa-times"></i></span>
                                                    </a>';
                                                    } elseif ($row['trangThai'] == 'Đã duyệt') {
                                                        echo '<span class="text alert-success font-weight-bold">Đã duyệt</span>';
                                                    } else {
                                                        echo '<span class="text alert-danger font-weight-bold">Không duyệt</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                                <ul class="pagination">
                                    <?php

                                    if ($page > 1) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="calendar_manager.php?page=<?= ($page - 1) ?>">Trước</a>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    for ($i = 1; $i <= $total_page; $i++) :
                                        $active = "";
                                        if ($i == $current_page) {
                                            $active = 'active';
                                        }
                                    ?>
                                        <li class="page-item <?= $active ?>">
                                            <a class="page-link" href="calendar_manager.php?page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor ?>
                                    <?php
                                    if ($i > $page) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="calendar_manager.php?page=<?= ($page + 1) ?> ">Sau</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog detail calendar -->
        <div id="detail-calender-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Thông tin chi tiết ngày nghỉ</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="fomr-group">
                            <input type="hidden" name="load_calendar_idnv" id="load_calendar_idnv">
                        </div>
                        <div class="form-group">
                            <label>Mã nhân viên: </label>
                            <span id="load_idnv_calendar"></span>
                        </div>
                        <div class="form-group">
                            <label>Họ và tên: </label>
                            <span id="load_usernv_calendar" class="text-alert font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Chức vụ: </label>
                            <span id="load_positionnv_calendar"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Số ngày đã nghỉ: </label>
                                    <span id="load_dayoffnv"></span>
                                </div>
                                <div class="col">
                                    <label>Số ngày nghỉ còn lại: </label>
                                    <span id="load_restdaynv"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 class="font-weight-bold">Yêu cầu xin nghỉ</h5>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Số ngày yêu cầu: </label>
                                    <span id="load_reqdaynv"></span>
                                </div>
                                <div class="col">
                                    <label>Thời gian: </label>
                                    <span id="load_timenv"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Lí do: </label>
                            <p id="load_reasonnv"></p>
                        </div>
                        <span class="alert" id="status_calendarnv"></span>
                    </div>
                    <div class="modal-footer pull-left">
                        <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cancel calendar -->
        <div id="cancel-calendar-nv" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Phê duyệt</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idnv_cancel_calendar" id="idnv_cancel_calendar">
                        <p class="alert alert-danger">Bạn có chắc rằng không duyệt đơn xin nghỉ phép này ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="btn_cancel_calendarnv">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Accept calendar -->
        <div id="accept-calendar-nv" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Phê duyệt</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idnv_accept_calendar" id="idnv_accept_calendar">
                        <p class="alert alert-success">Bạn có chắc rằng muốn duyệt đơn xin nghỉ phép này ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-success" id="btn_accept_calendarnv">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog create calendar -->
        <div id="create-calendar" class="modal fade" role="dialog">
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
                                    <input name="id_tp_create" class="form-control" type="text" id="id_tp_create" value="<?= $info['id'] ?>" readonly>
                                </div>
                                <input name="user_tp_create" class="form-control" type="hidden" id="user_tp_create" value="<?= $info['username'] ?>" readonly>
                                <div class="col">
                                    <label>Họ và tên</label>
                                    <input name="name_tp_create" class="form-control" type="text" id="name_tp_create" value="<?= $info['fullname'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Chức vụ</label>
                                    <input name="position_tp_create" class="form-control" type="text" id="position_tp_create" value="<?= $info['position'] ?>" readonly>
                                </div>
                                <div class="col">
                                    <label>Phòng ban</label>
                                    <input name="department_tp_create" class="form-control" type="text" id="department_tp_create" value="<?= $info['department'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Số ngày nghỉ còn lại</label>
                                    <input name="rest_day" class="form-control" type="text" id="rest_day" value="<?= $rest_dayoff ?>" readonly>
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
                            <input name="from_date" class="form-control" type="date" id="from_date">
                            <span id="err-from-date" class="text-danger font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Đến ngày</label>
                            <input name="to_date" class="form-control" type="date" id="to_date">
                            <span id="err-to-date" class="text-danger font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Lí do</label>
                            <textarea id="reason" name="reason" rows="4" class="form-control" placeholder="Thêm lí do nghỉ"></textarea>
                            <span id="err-reason" class="text-danger font-weight-bold"></span>
                        </div>
                    </div>
                    <div class="modal-footer pull-left">
                        <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn br-color" id="btn-create-calender-tp">Submit</button>
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