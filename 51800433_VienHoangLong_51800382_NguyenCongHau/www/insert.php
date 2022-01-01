<?php
require_once('db.php');
$ud_employee_id = 47;
$data = [];
$result = get_information_load_employee($ud_employee_id);
if (mysqli_fetch_assoc($result) > 0) {
    foreach ($result as $row) {
        array_push($data, $row);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
// $ud_employee_fullname = 'Hoàng Long Viên';
// $ud_employee_username = 'vienhoanglong1';
// $ud_employee_position = 'Manager';
// $ud_employee_email = 'vienhoanglong789@gmail.com';
// $ud_employee_id = 47;
// $result = update_employee($ud_employee_fullname, $ud_employee_username, $ud_employee_position, $ud_employee_email, $ud_employee_id);
// print_r($result);
// $rs_employee_id = 48;
// $result = reset_password_default($rs_employee_id);
// print_r($result);
// function get_user_byid($employee_id)
// {
//     $conn = open_database();
//     $sql = 'select username from users where id = ?';
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('i', $employee_id);
//     $stm->execute();
//     $result = $stm->get_result();
//     $data = $result->fetch_assoc();
//     return $data;
// }
// function reset_password_default($employee_id)
// {
//     $user = implode(get_user_byid($employee_id));
//     $pass = $user;
//     $activated = 0;
//     $hash = password_hash($pass, PASSWORD_DEFAULT);
//     $rand = random_int(0, 1000);
//     $token = md5($user . '+' .  $rand);
//     // $sql = 'update users set password = ?, activated = ? where user = ?';
//     $sql = 'update users set activated = ?, password = ?, activate_token = ? where username = ?';
//     $conn = open_database();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('isss', $activated, $hash, $token, $user);

//     if (!$stm->execute()) {
//         return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
//     }
//     return array('code' => 0, 'error' => 'Reset mật khẩu về mặc định thành công!');
// }