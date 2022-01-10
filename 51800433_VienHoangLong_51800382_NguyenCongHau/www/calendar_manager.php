<?php
session_start();
require_once('db.php');
//Phân trang
if (isset($_GET['page'])) {
    $numpage = $_GET['page'];
} else {
    $numpage = 1;
}
$num_per_page = 05;
$start_from = ($numpage - 1) * 05;
$title_page = 'calendar_manager';
$user = $_SESSION['user'];
$info = get_information($user);
$info = $info->fetch_assoc();
$rest_dayoff = calendar_rest($user);
$calendar_result = load_result_calendar($user, $start_from, $num_per_page);
$er_calendar = array(
    'error' => 0
);
if (isset($_POST['username']) && isset($_POST['ngayBatDau']) && isset($_POST['ngayKetThuc']) && isset($_POST['liDo']) && isset($_POST['ngayConLai'])) {
    $username = $_POST['username'];
    $ngayBatDau = $_POST['ngayBatDau'];
    $ngayKetThuc = $_POST['ngayKetThuc'];
    $liDo = $_POST['liDo'];
    $ngayConLai = $_POST['ngayConLai'];
    $result = create_calendar($username, $ngayBatDau, $ngayKetThuc, $liDo, $ngayConLai);
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
                    <div class="card shadow mb-4 mt-5">
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
                        <div class="card-body">
                            <h5 class="text text-primary">Bảng danh sách yêu cầu nghỉ phép</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Họ và tên</th>
                                            <th>Yêu cầu</th>
                                            <th>Thời gian</th>
                                            <th>Lí do</th>
                                            <th>Phê duyệt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Viên Hoàng Long</td>
                                            <td>3 Ngày</td>
                                            <td>12/12/21-15/12/21</td>
                                            <td>
                                                <a class="btn click-detail-calender text-primary">Chi tiết<a>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-icon-split click-accept-calender">
                                                    <span class="icon text-white-100"><i class="fa fa-check"></i></span>

                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-cancel-calender">
                                                    <span class="icon text-white-100"><i class="fa fa-times"></i></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
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
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h3 class="modal-title">Thông tin chi tiết ngày nghỉ</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="num-rd">Mã nhân viên: </label>
                                <span>NV01</span>
                            </div>
                            <div class="form-group">
                                <label for="name-rd">Họ và tên: </label>
                                <strong>Viên Hoàng Long</strong>
                            </div>
                            <div class="form-group">
                                <label for="name-rmd">Chức vụ: </label>
                                <span>Nhân viên phòng CNTT</span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="name-rmd">Số ngày đã nghỉ: </label>
                                        <span>5 ngày</span>
                                    </div>
                                    <div class="col">
                                        <label for="name-rmd">Số ngày nghỉ còn lại: </label>
                                        <span>9 ngày</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <h5 class="font-weight-bold">Yêu cầu xin nghỉ</h5>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="name-rmd">Số ngày yêu cầu: </label>
                                        <span>3 ngày</span>
                                    </div>
                                    <div class="col">
                                        <label for="name-rmd">Thời gian: </label>
                                        <span>12/12/21 - 15/12/21</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name-rmd">Lí do: </label>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus optio earum at velit ipsa harum ipsum, minus a officia commodi? Blanditiis iusto vel repellat atque facere assumenda asperiores sint veritatis?</p>
                            </div>
                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
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
                        <p>Bạn có chắc rằng không duyệt đơn xin nghỉ phép này ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger">Yes</button>
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
                                    <input name="used_day" class="form-control" type="text" id="used_day" value="<?= 15 - $rest_dayoff ?>" readonly>
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