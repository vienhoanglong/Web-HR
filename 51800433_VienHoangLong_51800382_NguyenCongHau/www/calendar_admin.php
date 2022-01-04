<?php
session_start();

require_once('db.php');
$page = 'calendar_admin';
$calendar = load_calendar();


if (isset($_POST['checking_calendar'])) {
    $id_calendar = $_POST['id_calendar'];
    $data = [];
    $username = load_calendar_byuser($id_calendar);
    $rest_day = load_accept_calendar($username);
    array_push($data, $rest_day);
    $temp = get_information($username);
    $result1 = $temp->fetch_assoc();
    array_push($data, $result1);
    $result = load_calendar_byid($id_calendar);
    if (mysqli_fetch_assoc($result) > 0) {
        foreach ($result as $row) {
            array_push($data, $row);
            header('Content-Type: application/json');
            die(json_encode($data));
        }
    }
}
$er_accept = array(
    'error' => 0
);
if (isset($_POST['checking_accept'])) {
    $id_calendar_admin = $_POST['id_calendar_admin'];
    $calendar = load_calendar_byid($id_calendar_admin);
    $calendar = $calendar->fetch_assoc();
    $a = $calendar['ngayKetThuc'];
    $b = $calendar['ngayBatDau'];
    $user = $calendar['username'];
    $ngayBatDau = date("d-m-Y", strtotime($a));
    $ngayKetThuc = date("d-m-Y", strtotime($b));
    $dayoff = check_dayoff($ngayKetThuc, $ngayBatDau);
    $result = update_status_accept_calendar($user, $dayoff);
    if ($result['code'] == 0) {
        $er_accept['error'] = 0;
        $er_accept = 'Phê duyệt thành công định thành công!';
    }
    if ($result['code'] == 2) {
        $er_accept['error'] = 1;
        $er_accept = 'Phê duyệt không thành công!';
    }
    die(json_encode($er_accept));
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
                    <div class="card shadow mb-4 mt-5">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Bảng Danh Sách Yêu Cầu Xin Nghỉ Phép</h4>
                            <h6 class="font-weight-bold text-danger">*Note: Tổng ngày nghỉ trong năm là 12 ngày nhân viên, trưởng phòng 15 ngày</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã nhân viên</th>
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
                                                <td id="id_calendar_admin"><?= $row['id'] ?></td>
                                                <td><?= $row['username'] ?></td>
                                                <td><?= check_dayoff($row['ngayBatDau'], $row['ngayKetThuc']) ?> ngày</td>
                                                <td><?= date('d/m/Y', strtotime($row['ngayBatDau'])) . '-' . date('d/m/Y', strtotime($row['ngayKetThuc'])) ?></td>
                                                <td>
                                                    <a class="btn click-detail-calender text-primary">Chi tiết<a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['trangThai'] == 'Chờ duyệt') {
                                                        echo '<a class="btn btn-success btn-icon-split click-accept-calender">
                                                    <span class="icon text-white-100"><i class="fa fa-check"></i></span>
                                                    </a>
                                                    <a class="btn btn-danger btn-icon-split click-cancel-calender">
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
        <!-- Dialog detail calendar -->
        <div id="detail-calender" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title">Thông tin chi tiết ngày nghỉ</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="fomr-group">
                            <input type="hidden" name="load_calendar_id" id="load_calendar_id">
                        </div>
                        <div class="form-group">
                            <label>Mã nhân viên: </label>
                            <span id="load_id_calendar"></span>
                        </div>
                        <div class="form-group">
                            <label>Họ và tên: </label>
                            <span id="load_user_calendar" class="text-alert font-weight-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Chức vụ: </label>
                            <span id="load_position_calendar"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Số ngày đã nghỉ: </label>
                                    <span id="load_dayoff"></span>
                                </div>
                                <div class="col">
                                    <label>Số ngày nghỉ còn lại: </label>
                                    <span id="load_restday"></span>
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
                                    <span id="load_reqday"></span>
                                </div>
                                <div class="col">
                                    <label>Thời gian: </label>
                                    <span id="load_time"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Lí do: </label>
                            <p id="load_reason"></p>
                        </div>
                        <span class="alert" id="status_calendar"></span>
                    </div>
                    <div class="modal-footer pull-left">
                        <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Cancel calendar -->
        <div id="cancel-calendar" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Phê duyệt</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p class="alert alert-danger">Bạn có chắc rằng không duyệt đơn xin nghỉ phép này ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Accept calendar -->
        <div id="accept-calendar" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Phê duyệt</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="iduser_calendar" id="iduser_calendar">
                        <p class="alert alert-success">Bạn có chắc rằng muốn duyệt đơn xin nghỉ phép này ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-success" id="btn_accept_calendar">Yes</button>
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