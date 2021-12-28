<?php

// $host = 'mysql-server'; // tên mysql server
// $user = 'root';
// $pass = 'root';
// $db = 'company_management'; // tên databse

// $conn = new mysqli($host, $user, $pass, $db);
// $conn->set_charset("utf8");
// if ($conn->connect_error) {
//     die('Không thể kết nối database: ' . $conn->connect_error);
// }
define('HOST', 'mysql-server');
define('USER', 'root');
define('PASS', 'root');
define('DB', 'company_management');

function open_database()
{
    $conn = new mysqli(HOST, USER, PASS, DB);
    if ($conn->connect_error) {
        die('Connect error: ' . $conn->connect_error);
    }
    return $conn;
}
function login($user, $pass)
{
    $sql = "select * from users where username = ?";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        return null;
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return null;
    }

    $data = $result->fetch_assoc();

    $hashed_password = $data['password'];
    if (!password_verify($pass, $hashed_password)) {
        return null;
    } else return $data;
}
function change_password($user, $pass)
{
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = 'update users set activated = 1, password = ? where username = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $hash, $user);

    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Cant Execute');
    }
    return array('code' => 0, 'error' => 'Password is changed successfully!');
}
function get_information($user)
{
    $conn = open_database();
    $sql = 'select * from users where username = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}
function check_user($user)
{
    $sql = 'select username from users where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function get_name_department()
{
    $conn = open_database();
    $sql = 'select * from department';
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->get_result();
    while ($row[] = $result->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}
function is_email_exists($email)
{
    $sql = 'select username from users where email = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $email);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function check_manager_department($id_department)
{
    $sql = 'select manager from department where idDepartment = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_department);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function get_department_byid($idDepartment)
{
    $sql = 'select nameDepartment from department where idDepartment = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_department);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
function create_employee($user, $fullname, $email, $idDepartment, $position)
{
    if (check_user($user)) {
        return array('code' => 1, 'error' => 'Tài khoản nhân viên đã tồn tại');
    }
    if (is_email_exists($email)) {
        return array('code' => 4, 'error' => 'Email đã tồn tại');
    }
    if (check_manager_department($user)) {
        return array('code' => 3, 'error' => 'Hiện phòng ban này đã có trưởng phòng');
    }
    $department = get_department_byid($idDepartment);
    $role = ($position === 'manager') ? $role = 1 : $role = 2;
    $pass = $user;
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $rand = random_int(0, 1000);
    $token = md5($user . '+' . $rand);
    $sql = 'insert into users(username, fullname, email, password, activate_token, department, position, role) values(?,?,?,?,?,?,?,?)';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('sssssssi', $user, $fullname, $email, $hash, $token, $department, $position, $role);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Tạo nhân viên mới thành công!');
}
