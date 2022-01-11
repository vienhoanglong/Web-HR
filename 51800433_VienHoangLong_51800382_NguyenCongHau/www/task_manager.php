<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
require_once('db.php');
$page = 'task_manager';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
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
                    <div class="card shadow mb-4 mt-3">
                        <!-- Card Body -->
                        <div class="card-header py-3">
                            <h4 class="font-weight-bold text-primary">Danh Sách Công Việc</h4>
                            <div class="click-create-task">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    New Task</button>
                            </div>
                        </div>
                        <!-- Hậu list card -->
                        <div class="row ml-2 mr-2 mt-4">
                            <!-- card_task -->

                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body " id="card_item">
                                        <div class="list-group list-group-flush" id="click_start_task_employee">
                                            <a class="list-group-item" href="#">Thiết kế poster ngày tết 2022 âm lịch</a>
                                            <a class="list-group-item" href="#">Thực hiện: Nguyễn Công Hậu</a>
                                            <a class="list-group-item" href="#">Trạng thái: chưa hoàn thành</a>
                                        </div>
                                        <nav class="dropdown">
                                            <div class="drop_card" id="dropdownMenuButton">
                                                <a type="text">
                                                    <i class="fas fa-ellipsis-h "></i>
                                                </a>
                                                <div class="dropdown-content dropdown-menu shadow-sm">
                                                    <a class="click-preview-task">Xem</a>
                                                    <a class="click-delete-task">Hủy</a>
                                                    <a class="click-update-task">Sửa</a>
                                                    <a class="click-submit-task">Submit</a>
                                                    <a class="click-view-submit-task">Xác nhận</a>
                                                </div>
                                            </div>
                                        </nav>

                                        <a class="deadline_a">Deadline: 01/01/2022 11:59 AM</a>

                                        <p></p>
                                        <nav class="deadline_task">
                                            <div id="statusbar row">
                                                <a class="progress_task btn bg-primary text-white">IN PROGRESS</a>
                                                <a class="waiting_task btn bg-warning text-white">WAITING</a>
                                                <a class="reject_task btn bg-info text-white">REJECTED</a>
                                                <a class="complete_task btn bg-success text-white">COMPLETED</a>
                                                <a class="cancel_task btn bg-danger text-white">CANCELED</a>
                                            </div>
                                        </nav>
                                        <nav class="check_new">
                                            <img class="check_img" src="/images/new.svg">
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body " id="card_item">
                                        <div class="list-group list-group-flush" id="click_start_task_employee">
                                            <a class="list-group-item" href="#">Thiết kế poster ngày tết 2022 âm lịch</a>
                                            <a class="list-group-item" href="#">Thực hiện: Nguyễn Công Hậu</a>
                                            <a class="list-group-item" href="#">Trạng thái: chưa hoàn thành</a>
                                        </div>
                                        <nav class="dropdown">
                                            <div class="drop_card" id="dropdownMenuButton">
                                                <a type="text">
                                                    <i class="fas fa-ellipsis-h "></i>
                                                </a>
                                                <div class="dropdown-content dropdown-menu shadow-sm">
                                                    <a class="click-preview-task">Xem</a>
                                                    <a class="click-delete-task">Hủy</a>
                                                    <a class="click-update-task">Sửa</a>
                                                    <a class="click-submit-task">Submit</a>
                                                    <a class="click-view-submit-task">Xác nhận</a>
                                                </div>
                                            </div>
                                        </nav>

                                        <a class="deadline_a">Deadline: 01/01/2022 11:59 AM</a>

                                        <p></p>
                                        <nav class="deadline_task">
                                            <div id="statusbar row">
                                                <a class="progress_task btn bg-primary text-white">IN PROGRESS</a>
                                                <a class="waiting_task btn bg-default text-white">WAITING</a>
                                                <a class="reject_task btn  bg-default text-white">REJECTED</a>
                                                <a class="complete_task btn  bg-default text-white">COMPLETED</a>
                                                <a class="cancel_task btn  bg-default text-white">CANCELED</a>
                                            </div>
                                        </nav>
                                        <nav class="check_new">
                                            <img class="check_img" src="/images/new.svg">
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body " id="card_item">
                                        <div class="list-group list-group-flush" id="click_start_task_employee">
                                            <a class="list-group-item" href="#">Thiết kế poster ngày tết 2022 âm lịch</a>
                                            <a class="list-group-item" href="#">Thực hiện: Nguyễn Công Hậu</a>
                                            <a class="list-group-item" href="#">Trạng thái: chưa hoàn thành</a>
                                        </div>
                                        <nav class="dropdown">
                                            <div class="drop_card" id="dropdownMenuButton">
                                                <a type="text">
                                                    <i class="fas fa-ellipsis-h "></i>
                                                </a>
                                                <div class="dropdown-content dropdown-menu shadow-sm">
                                                    <a class="click-preview-task">Xem</a>
                                                    <a class="click-delete-task">Hủy</a>
                                                    <a class="click-update-task">Sửa</a>
                                                    <a class="click-submit-task">Submit</a>
                                                    <a class="click-view-submit-task">Xác nhận</a>
                                                </div>
                                            </div>
                                        </nav>

                                        <a class="deadline_a">Deadline: 01/01/2022 11:59 AM</a>

                                        <p></p>
                                        <nav class="deadline_task">
                                            <div id="statusbar row">
                                                <a class="progress_task btn bg-primary text-white">IN PROGRESS</a>
                                                <a class="waiting_task btn bg-primary text-white">WAITING</a>
                                                <a class="reject_task btn bg-primary text-white">REJECTED</a>
                                                <a class="complete_task btn bg-primary text-white">COMPLETED</a>
                                                <a class="cancel_task btn bg-primary text-white">CANCELED</a>
                                            </div>
                                        </nav>
                                        <nav class="check_new">
                                            <img class="check_img" src="/images/new.svg">
                                        </nav>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog create a new task-->
        <div id="new-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <!-- <div class="form-group">
                                <label for="username">Nhân viên thực hiện</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                                <span id="er-username" class="text-danger font-weight-bold"></span>
                            </div> -->
                            <div class="form-group">
                                <label for="task_employee">Nhân viên thực hiện:</label>
                                <select class="form-control" name="position" id="task_employee">
                                    <option value="employee">Nhân viên 1</option>
                                    <option value="employee">Nhân viên 2</option>
                                    <option value="employee">Nhân viên 3</option>
                                    <option value="employee">Nhân viên 4</option>
                                </select>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_time">Thời hạn:</label>
                                <input class="form-control" type="datetime-local" id="task_time" name="task_time">
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="myFile" multiple size="50" onchange="myFunction()">
                            <p id="demo"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog view task-->
        <div id="preview-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xem công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <!-- <div class="form-group">
                                <label for="username">Nhân viên thực hiện</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                                <span id="er-username" class="text-danger font-weight-bold"></span>
                            </div> -->
                            <div class="form-group">
                                <label for="task_employee">Nhân viên thực hiện:</label>
                                <select class="form-control" name="position" id="task_employee">
                                    <option value="employee">Nhân viên 1</option>
                                    <option value="employee">Nhân viên 2</option>
                                    <option value="employee">Nhân viên 3</option>
                                    <option value="employee">Nhân viên 4</option>
                                </select>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_time">Thời hạn:</label>
                                <input class="form-control" type="datetime-local" id="task_time" name="task_time">
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="myFile" multiple size="50" onchange="S()">
                            <p id="demo"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog view task employee-->
        <div id="start_task_employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xem công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <!-- <div class="form-group">
                                <label for="username">Nhân viên thực hiện</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                                <span id="er-username" class="text-danger font-weight-bold"></span>
                            </div> -->
                            <div class="form-group">
                                <label for="task_employee">Nhân viên thực hiện:</label>
                                <select class="form-control" name="position" id="task_employee">
                                    <option value="employee">Nhân viên 1</option>
                                    <option value="employee">Nhân viên 2</option>
                                    <option value="employee">Nhân viên 3</option>
                                    <option value="employee">Nhân viên 4</option>
                                </select>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_time">Thời hạn:</label>
                                <input class="form-control" type="datetime-local" id="task_time" name="task_time">
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="myFile" multiple size="50" onchange="S()">
                            <p id="demo"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Start</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog update task -->
        <div id="update-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <!-- <div class="form-group">
                                <label for="username">Nhân viên thực hiện</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                                <span id="er-username" class="text-danger font-weight-bold"></span>
                            </div> -->
                            <div class="form-group">
                                <label for="task_employee">Nhân viên thực hiện:</label>
                                <select class="form-control" name="position" id="task_employee">
                                    <option value="employee">Nhân viên 1</option>
                                    <option value="employee">Nhân viên 2</option>
                                    <option value="employee">Nhân viên 3</option>
                                    <option value="employee">Nhân viên 4</option>
                                </select>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_time">Thời hạn:</label>
                                <input class="form-control" type="datetime-local" id="task_time" name="task_time">
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="myFile" multiple size="50" onchange="myFunction()">
                            <p id="demo"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog submit task employee-->
        <div id="submit-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="subFile" multiple size="50" onchange="submitFile()">
                            <p id="view_file_submit"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog view submit task -->
        <div id="view-submit-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action="" novalidate>
                            <div class="form-group">
                                <label for="title_task">Tiêu đề:</label>
                                <input name="title_task" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="title_task">
                                <span id="er-fullname" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label for="task_note">Mô tả:</label>
                                <textarea class="form-control" rows="5" id="task_note"></textarea>
                            </div>
                            <input type="file" id="subFile" multiple size="50" onchange="submitFile()">
                            <p id="view_file_submit"></p>
                            <span class="alert-danger">

                            </span>
                            <span class="alert-success">

                            </span>
                            <div class="modal-footer">
                                <button id="cancel_dialog" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger">Reject</button>
                                <button type="button" id="btn-create-employee" class="btn btn-primary">Complete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog delete task -->
        <div id="delete-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Hủy công việc</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn xóa công việc này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary">Yes</button>
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