<?php
require_once('db.php');
$errors = array(
    'error' => 0
);
if (isset($_POST['id_reject_task']) && isset($_POST['user_reject']) && isset($_POST['reject_task_desc'])) {
    $id_reject_task = $_POST['id_reject_task'];
    $user_reject = $_POST['user_reject'];
    $reject_task_desc = $_POST['reject_task_desc'];
    $file = $_FILES['rejectFile'];
    $deadline = isset($_POST['deadline_task']) ? $_POST['deadline_task'] : null;
    $result = reject_task($id_reject_task, $reject_task_desc, $user_reject, $file, $deadline);
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
        $errors['command'] = 'Reject công việc không thành công';
    }
    if ($result['code'] == 1) {
        $errors['error'] = 1;
        $errors['file'] = 'Không upload được file, vui lòng thử lại';
    }
    die(json_encode($errors));
}
$er_cancel = array(
    'error' => 0
);
//Cập nhật trạng thái task khi nhân viên xác nhận công việc
if (isset($_POST['cancel_task'])) {
    $id_task = $_POST['id_task'];
    $status = 'Canceled';
    $result = update_status_task($id_task, $status);
    if ($result['code'] == 0) {
        $er_cancel['error'] = 0;
        $er_cancel = 'Cập nhật thành công!';
    }
    if ($result['code'] == 2) {
        $er_cancel['error'] = 1;
        $er_cancel = 'Cập nhật không thành công!';
    }
    die(json_encode($er_cancel));
}
$errors_update = array(
    'error' => 0
);
if (isset($_POST['id_update_task'])) {
    $id_update_task = $_POST['id_update_task'];
    $update_task_title = $_POST['update_task_title'];
    $update_task_desc = $_POST['update_task_desc'];
    $deadline = (($_POST['update_deadline_task']) != '') ? $_POST['update_deadline_task'] : $_POST['deadline_task_old'];
    $file = $_FILES['updateFile'];
    $fileold = $_POST['file_task_old'];
    $result = update_task($id_update_task, $update_task_title, $update_task_desc, $deadline, $file, $fileold);
    if ($result['code'] == 3) {
        $errors_update['error'] = 1;
        $errors_update['typefile'] = 'Định dạng file không được hỗ trợ, vui lòng chọn định dạng khác';
    }
    if ($result['code'] == 4) {
        $errors_update['error'] = 1;
        $errors_update['sizefile'] = 'Kích thước file không vượt quá 100MB';
    }
    if ($result['code'] == 2) {
        $errors_update['error'] = 1;
        $errors_update['command'] = 'Cập nhật công việc không thành công';
    }
    if ($result['code'] == 1) {
        $errors_update['error'] = 1;
        $errors_update['file'] = 'Không upload được file, vui lòng thử lại';
    }
    die(json_encode($errors_update));
}
//Đánh giá kết quả công việc

if (isset($_POST['complete_task']) && isset($_POST['id_task']) && isset($_POST['rating'])) {
    $id_task = $_POST['id_task'];
    $rating = $_POST['rating'];
    $result = complete_task($id_task, $rating);
}
