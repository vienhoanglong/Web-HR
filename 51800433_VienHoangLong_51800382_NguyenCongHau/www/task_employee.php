<?php
require_once('db.php');
session_start();

$er_start = array(
    'error' => 0
);
//Cập nhật trạng thái task khi nhân viên xác nhận công việc
if (isset($_POST['start_task'])) {
    $id_task = $_POST['id_task'];
    $status = 'In Progress';
    $result = update_status_task($id_task, $status);
    if ($result['code'] == 0) {
        $er_start['error'] = 0;
        $er_start = 'Cập nhật thành công!';
    }
    if ($result['code'] == 2) {
        $er_start['error'] = 1;
        $er_start = 'Cập nhật không thành công!';
    }
    die(json_encode($er_start));
}
$errors = array(
    'error' => 0
);
//Nhân viên nộp kết quả công việc
if (isset($_POST['id_submit_task']) && isset($_POST['user_submit']) && isset($_POST['submit_task_desc'])) {
    $id_submit_task = $_POST['id_submit_task'];
    $user_submit = $_POST['user_submit'];
    $submit_task_desc = $_POST['submit_task_desc'];
    $file = $_FILES['subFile'];
    $result = submit_task($id_submit_task, $submit_task_desc, $user_submit, $file);
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
        $errors['command'] = 'nộp công việc không thành công';
    }
    if ($result['code'] == 1) {
        $errors['error'] = 1;
        $errors['file'] = 'Không upload được file, vui lòng thử lại';
    }
    die(json_encode($errors));
}
