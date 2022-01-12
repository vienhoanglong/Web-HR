<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
require_once('db.php');
$title_page = 'task_manager';
//Load list employee
$department = $_SESSION['department'];
$list_employee = get_list_employee_department($department);
$tasks = load_task();

$errors = array(
    'error' => 0
);
if (isset($_POST['task_title']) && isset($_POST['task_employee']) && isset($_POST['task_time']) && isset($_POST['task_desc'])) {
    $task_title = $_POST['task_title'];
    $task_employee = $_POST['task_employee'];
    $task_time = $_POST['task_time'];
    $task_desc = $_POST['task_desc'];
    $name_manager = $_SESSION['user'];
    $department = $_SESSION['department'];
    $file = $_FILES['myFile'];
    //upload file 
    $result = create_new_task($name_manager, $task_employee, $department, $task_title, $task_desc, $file, $task_time);
    if ($result['code'] == 3) {
        $errors['error'] = 1;
        $errors['typefile'] = 'Định dạng file không được hỗ trợ, vui lòng chọn định dạng khác';
    }
    if ($result['code'] == 4) {
        $errors['error'] = 1;
        $errors['sizefile'] = 'Kích thước file không vượt quá 100MB';
    }
    if ($result['code'] == 2) {
        $errors['error'] = 1;
        $errors['command'] = 'Tạo công việc mới không thành công';
    }
    if ($result['code'] == 1) {
        $errors['error'] = 1;
        $errors['file'] = 'Không upload được file, vui lòng thử lại';
    }
    die(json_encode($errors));
}
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
                        <div class="row ml-2 mr-2 mt-4">
                            <!-- card_task -->
                            <?php
                            while ($row = mysqli_fetch_assoc($tasks)) { ?>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body" id="card_item">
                                            <div class="list-group list-group-flush" id="click_start_task_employee">
                                                <a class="list-group-item" href="#"><?= $row['name_task'] ?></a>
                                                <a class="list-group-item" href="#"><?= get_fullname($row['name_employee']) ?></a>
                                                <a class="list-group-item" href="#">Trạng thái: <?= $row['status'] ?></a>
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

                                            <a class="deadline_a"><?= $row['deadline'] ?></a>

                                            <p></p>
                                            <nav class="deadline_task">
                                                <div id="statusbar row">
                                                    <a class="progress_task btn bg-default text-white">IN PROGRESS</a>
                                                    <a class="waiting_task btn bg-default text-white">WAITING</a>
                                                    <a class="reject_task btn bg-default text-white">REJECTED</a>
                                                    <a class="complete_task btn bg-default text-white">COMPLETED</a>
                                                    <a class="cancel_task btn bg-default text-white">CANCELED</a>
                                                </div>
                                            </nav>
                                            <nav class="check_new">
                                                <?php
                                                if ($row['status'] == 'New') {
                                                    echo '<img class="check_img" src="/images/new.svg">';
                                                } else {
                                                }
                                                ?>

                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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
                        <span class="alert-danger"></span>
                        <span class="alert-success"></span>
                        <form action="" id="form_create_task" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tiêu đề:</label>
                                <input name="task_title" class="form-control" type="text" placeholder="Nhập tiêu đề.." id="task_title">
                                <span id="err-tasktitle" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Nhân viên thực hiện:</label>
                                <select class="form-control" name="task_employee" id="task_employee">
                                    <?php
                                    foreach ($list_employee as $key => $value) :
                                        echo '<option value =' . $value['username'] . '>' . $value['fullname'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                                <span id="err-taskemployee" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Thời hạn:</label>
                                <input class="form-control" type="datetime-local" id="task_time" name="task_time">
                                <span id="err-tasktime" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="5" name="task_desc" id="task_desc"></textarea>
                                <span id="err-taskdesc" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <input type="file" id="myFile" name="myFile" multiple size="50" onchange="myFunction()">
                                <p id="demo"></p>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" form="form_create_task">Create</button>
                        </div>
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
                            <input type="file" id="" multiple size="50" onchange="S()">
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
                            <input type="file" id="" multiple size="50" onchange="myFunction()">
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