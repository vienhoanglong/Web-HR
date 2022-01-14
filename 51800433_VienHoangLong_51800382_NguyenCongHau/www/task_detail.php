<?php
session_start();
require_once('db.php');
if (isset($_GET['id_task'])) {
    $id_task = $_GET['id_task'];
}
$detail_task = load_task_byid($id_task);
$activity_task = history_task($id_task);
$task_submit = submit_task_new($id_task);
$fullname = (isset($task_submit['user'])) ? get_fullname($task_submit['user']) : '';
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
    <title>Chi tiết công việc</title>
</head>

<body>
    <div class="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content">
            <?php include('includes/navbar.php'); ?>
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="card shadow mt-5">
                        <div class="mt-2 p-2">
                            <h5>Thông tin chi tiết công việc</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <dl>
                                        <dt><b class="border-bottom border-primary">Tiêu đề</b></dt>
                                        <dd><?= $detail_task['name_task'] ?></dd>
                                        <dt><b class="border-bottom border-primary">Mô tả chi tiết</b></dt>
                                        <dd><?= $detail_task['desc_task'] ?></dd>
                                        <dt><b class="border-bottom border-primary">File đính kèm</b></dt>
                                        <dd></dd>
                                        <dd><a href="/uploads/task/<?= $detail_task['file'] ?>" class="text-primary" download><?= $detail_task['file'] ?></a></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl>
                                        <dt><b class="border-bottom border-primary">Deadline</b></dt>
                                        <dd><?= $detail_task['deadline'] ?></dd>
                                    </dl>
                                    <dl>
                                        <dt><b class="border-bottom border-primary">Trạng thái</b></dt>
                                        <dd>
                                            <span class='badge badge-danger'><?= $detail_task['status'] ?></span>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt><b class="border-bottom border-primary">Nhân viên thực hiện</b></dt>
                                        <dd>
                                            <div class="d-flex align-items-center mt-1">
                                                <img class="img-profile rounded-circle" src="/images/avatar.png">
                                                <b><?= get_fullname($detail_task['name_employee']) ?></b>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                                <?php
                                if ($_SESSION['role'] == 2) { ?>
                                    <div class="col-md-6 mb-3">
                                        <h6>Xác nhận công việc</h6>
                                        <?php if ($detail_task['status'] == 'New') { ?>
                                            <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" id="click-start-task">Start</button>
                                        <?php } else { ?>
                                            <span class="text badge-warning">Đã xác nhận</span>
                                        <?php } ?>
                                    </div>
                                    <?php if ($detail_task['status'] != 'New' && $detail_task['status'] != 'Canceled' && $detail_task['status'] != 'Completed') { ?>
                                        <div class="col-md-6 mb-3">
                                            <h6>Nộp kết quả</h6>
                                            <button type="button" class="btn btn-outline-primary bg-gradient-primary btn-sm" id="click-submit-task"><i class="fa fa-plus-circle" aria-hidden="true"></i></i> Submit</button>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($detail_task['rating'] != '') { ?>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="font-weight-bold">Đánh giá mức độ: <?= $detail_task['rating'] ?></h5>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['role'] == 1) { ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Chức năng</b>
                                <div class="card-tools">
                                    <?php if ($detail_task['status'] == 'New') { ?>
                                        <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" id="click-cancel-task">Hủy task</button>
                                        <button type="button" id="click-update-task" class="btn btn-primary bg-gradient-primary btn-sm">Chỉnh sửa task</button>
                                    <?php } ?>
                                    <?php if ($detail_task['status'] == 'Waiting' || $detail_task['status'] == 'Rejected') { ?>
                                        <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" data-toggle="collapse" data-target="#info_submit"><i class="fa fa-check" aria-hidden="true"></i> Task submit</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="card-body collapse" id="info_submit">
                                <b>Thông tin submit</b>
                                <div class="user-block">
                                    <img class="img-profile rounded-circle" src="/images/avatar.png">
                                    <span><?= $fullname ?></span>
                                    <span class="ml-1">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i><?= $task_submit['time_submit'] ?>
                                    </span>
                                    <?php if ($task_submit['submit_status'] == 'Turn in') { ?>
                                        <span class="text text-success"><?= $task_submit['submit_status'] ?></span>
                                    <?php } else { ?>
                                        <span class="text text-danger"><?= $task_submit['submit_status'] ?></span>
                                    <?php } ?>
                                    <div class="row ml-2">
                                        <span class="description">
                                            <span><?= $task_submit['comment'] ?></span>
                                        </span>
                                    </div>
                                    <div class="row ml-2">
                                        <span></span>
                                        <a href="/uploads/submit/<?= $task_submit['file_submit'] ?>" class="text-primary" download><?= $task_submit['file_submit'] ?></a>
                                    </div>
                                </div>
                                <div class="card-tool">
                                    <?php if ($detail_task['rating'] == null) { ?>
                                        <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" id="click-reject-task">Reject</button>
                                        <button type="button" class="btn btn-success bg-gradient-success btn-sm" id="click-complete-task">Complete</button>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <b>Tiến độ công việc</b>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" data-toggle="collapse" data-target="#history_submit"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử</button>
                            </div>
                        </div>
                        <div class="card-body collapse" id="history_submit">
                            <?php while ($row = mysqli_fetch_assoc($activity_task)) { ?>
                                <div class="user-block">
                                    <img class="img-profile rounded-circle" src="/images/avatar.png">
                                    <span><?= get_fullname($row['user']) ?></span>
                                    <span class="ml-1">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i><?= $row['time_submit'] ?>
                                    </span>
                                    <?php if ($row['submit_status'] == 'Turn in') { ?>
                                        <span class="text text-success"><?= $row['submit_status'] ?></span>
                                    <?php } else { ?>
                                        <span class="text text-danger"><?= $row['submit_status'] ?></span>
                                    <?php } ?>
                                    <div class="row ml-2">
                                        <span class="description">
                                            <span><?= $row['comment'] ?></span>
                                        </span>
                                    </div>
                                    <div class="row ml-2">
                                        <span></span>
                                        <a href="/uploads/submit/<?= $row['file_submit'] ?>" class="text-primary" download><?= $row['file_submit'] ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start task -->
        <div id="start-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Xác nhận nhận task</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_start_task" name="id_start_task" value="<?= $detail_task['id'] ?>">
                        <p>Bạn có chắc rằng muốn nhận công việc này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="btn_start_task">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit task -->
        <div id="submit-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nộp công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="form_submit_task" enctype="multipart/form-data">
                            <input type="hidden" id="id_submit_task" name="id_submit_task" value="<?= $detail_task['id'] ?>">
                            <input type="hidden" id="user_submit" name="user_submit" value="<?= $_SESSION['user'] ?>">
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="5" name="submit_task_desc" id="submit_task_desc"></textarea>
                                <span id="err-taskdesc" class="text-danger font-weight-bold"></span>
                            </div>
                            <input type="file" id="subFile" name="subFile" multiple size="50" onchange="submitFile()">
                            <p id="view_file_submit"></p>
                        </form>
                        <span class="alert-danger">

                        </span>
                        <span class="alert-success">

                        </span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button form="form_submit_task" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reject task -->
        <div id="reject-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="form_reject_task" enctype="multipart/form-data">
                            <input type="hidden" id="id_reject_task" name="id_reject_task" value="<?= $detail_task['id'] ?>">
                            <input type="hidden" id="user_reject" name="user_reject" value="<?= $_SESSION['user'] ?>">
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="3" id="reject_task_desc" name="reject_task_desc"></textarea>
                                <span id="err-rejectdesc" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="fomr-group mb-2">
                                <button class="btn btn-outline-success btn-sm" data-toggle="collapse" data-target="#deadline_ext">Gia hạn deadline</button>
                                <div class="form-group collapse mt-1 mb-2" id="deadline_ext">
                                    <label>Deadline <?= date('d/m/Y H:i:s', strtotime($detail_task['deadline'])) ?></label><br>
                                    <input type="datetime-local" id="deadline_task" name="deadline_task">
                                </div>

                            </div>
                            <input type="file" id="rejectFile" name="rejectFile" multiple size="50" onchange="submitFile()">
                            <p id="view_file_submit"></p>

                        </form>
                        <span class="alert-danger"></span>
                        <span class="alert-success"></span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button form="form_reject_task" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Cancel task -->
        <div id="cancel-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Hủy công việc</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_cancel_task" name="id_cancel_task" value="<?= $detail_task['id'] ?>">
                        <p>Bạn có chắc rằng muốn hủy công việc này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="btn_cancel_task">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update task -->
        <div id="update-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa công việc</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="form_update_task" enctype="multipart/form-data">
                            <input type="hidden" id="id_update_task" name="id_update_task" value="<?= $detail_task['id'] ?>">
                            <div class="form-group">
                                <label>Tiêu đề:</label>
                                <input class="form-control" type="text" id="update_task_title" name="update_task_title" value="<?= $detail_task['name_task'] ?>">
                                <span id="err-title" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Nhân viên thực hiện:</label>
                                <input class="form-control" type="text" value="<?= get_fullname($detail_task['name_employee']) ?>" readonly>
                                <span id="er-position" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="fomr-group mb-2">
                                <input type="hidden" id="deadline_task_old" name="deadline_task_old" value="<?= $detail_task['deadline'] ?>">
                                <a class="btn btn-outline-success btn-sm" data-toggle="collapse" data-target="#update_deadline">Gia hạn deadline</a>
                                <div class="form-group collapse mt-1 mb-2" id="update_deadline">
                                    <label>Deadline <?= date('d/m/Y H:i:s', strtotime($detail_task['deadline'])) ?></label><br>
                                    <input type="datetime-local" id="update_deadline_task" name="update_deadline_task">
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="5" cols="42" id="update_task_desc" name="update_task_desc"><?= $detail_task['desc_task'] ?></textarea>
                                <span id="err-desc" class="text-danger font-weight-bold"></span>
                            </div>
                            <label>Tệp đính kèm</label><br>
                            <input type="hidden" id="file_task_old" name="file_task_old" value="<?= $detail_task['file'] ?>">
                            <a class="text text-primary" href="/uploads/task/<?= $detail_task['file'] ?>" download><?= $detail_task['file'] ?></a><br><br>
                            <a class="btn btn-outline-success btn-sm" data-toggle="collapse" data-target="#update_file">Thay đổi file</a><br><br>
                            <div class="form-group collapse" id="update_file">
                                <input type="file" id="updateFile" name="updateFile" multiple size="50" onchange="myFunction()">
                                <p id="demo"></p>
                            </div>
                        </form>
                        <span class="alert-danger">

                        </span>
                        <span class="alert-success">

                        </span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button form="form_update_task" class="btn btn-primary">Change</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Complete task -->
        <div id="complete-task" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Đánh giá công việc</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <p>Vui lòng chọn mức độ hoàn thành task?</p>

                        <input type="hidden" id="id_complete_task" name="id_complete_task" value="<?= $detail_task['id'] ?>">
                        <div class="form-check">
                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="bag_task" name="complete" value="Bad" checked>Bad
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="ok_task" name="complete" value="Ok" checked>Ok
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="good_task" name="complete" value="Good">Good
                            </label>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" id="btn_complete_task">Submit</button>
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