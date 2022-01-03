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
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Thay đổi mật khẩu thành công!');
}
function change_new_password($user, $pass, $newpass)
{
    $sql = 'select * from users where username = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    $data = $result->fetch_assoc();
    $hashed_password = $data['password'];
    if (!password_verify($pass, $hashed_password)) {
        return array('code' => 1, 'error' => 'Mật khẩu hiện tại của bạn không đúng!');
    }
    $hash = password_hash($newpass, PASSWORD_DEFAULT);
    $sql1 = 'update users set password = ? where username = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql1);
    $stm->bind_param('ss', $hash, $user);

    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Thay đổi mật khẩu thành công!');
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
function get_information_load_employee($user)
{
    $conn = open_database();
    $sql = 'select * from users where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $user);
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
function check_manager_byname($nameDepartment)
{
    $sql = 'select manager from department where nameDepartment = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $nameDepartment);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
    if (!isset($data)) {
        return false;
    }
    return true;
}
function check_manager_byid($id_department)
{
    $sql = 'select status from department where idDepartment = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_department);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
    return $data;
}
function get_department_byid($idDepartment)
{
    $sql = 'select nameDepartment from department where idDepartment = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idDepartment);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
function create_employee($user, $fullname, $email, $department, $position)
{
    if (check_user($user)) {
        return array('code' => 1, 'error' => 'Tài khoản nhân viên đã tồn tại');
    }
    if (is_email_exists($email)) {
        return array('code' => 4, 'error' => 'Email đã tồn tại');
    }
    if (($position === 'Manager') && check_manager_byid($department) == 1) {
        return array('code' => 3, 'error' => 'Hiện phòng ban này đã có trưởng phòng');
    }
    $department = implode(get_department_byid($department));
    $role = ($position === 'Manager') ? $role = 1 : $role = 2;
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
    //Cập nhật trưởng phòng trong phòng ban
    if ($role == 1) {
        $sql1 = 'update department set manager = ?, status = 1 where nameDepartment = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql1);
        $stm->bind_param('ss', $user, $department);
        $stm->execute();
    }
    return array('code' => 0, 'error' => 'Tạo nhân viên mới thành công!');
}
function get_employee()
{
    $conn = open_database();
    $sql = 'select * from users where role between ? and ?';
    $role1 = 1;
    $role2 = 2;
    $stm = $conn->prepare($sql);
    $stm->bind_param('ii', $role1, $role2);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}
function delete_employee($employee_id)
{
    $conn = open_database();
    $sql = 'delete from users where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $employee_id);
    $stm->execute();
    if ($stm->affected_rows === 0) {
        return array('code' => 1, 'error' => 'Xóa không thành công!');
    }
    return array('code' => 0, 'error' => 'Xóa thành công!');
}
function update_employee($fullname, $user, $email, $employee_id)
{

    $conn = open_database();
    $sql = 'update users set fullname = ?, username = ?, email = ? where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssssii', $fullname, $user, $email, $employee_id);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Không thể thực hiện lệnh!');
    }

    return array('code' => 0, 'error' => 'Cập nhật nhân viên thành công!');
}
function get_user_byid($employee_id)
{
    $conn = open_database();
    $sql = 'select username from users where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $employee_id);
    $stm->execute();
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
function reset_password_default($employee_id)
{
    $user = implode(get_user_byid($employee_id));
    $pass = $user;
    $activated = 0;
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $rand = random_int(0, 1000);
    $token = md5($user . '+' .  $rand);
    // $sql = 'update users set password = ?, activated = ? where user = ?';
    $sql = 'update users set activated = ?, password = ?, activate_token = ? where username = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('isss', $activated, $hash, $token, $user);

    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Reset mật khẩu về mặc định thành công!');
}
function upload_img_profile($user, $avatar)
{
    $conn = open_database();
    $sql = 'update users set avatar = ? where username = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $avatar, $user);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Upload ảnh đại diện thành công!');
}
function check_department($name)
{
    $sql = 'select * from department where nameDepartment = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $name);
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
function get_department()
{

    $conn = open_database();

    $sql = 'select * from department';

    $stm = $conn->prepare($sql);

    $stm->execute();
    $data = $stm->get_result();
    return $data;
}
function create_department($name, $address, $desc)
{
    if (check_department($name)) {
        return array('code' => 1, 'error' => 'Phòng ban này đã tồn tại');
    }
    $conn = open_database();
    $sql = 'insert into department(nameDepartment, addressDepartment, descDepartment) values(?, ?, ?)';
    $stm = $conn->prepare($sql);
    $stm->bind_param('sss', $name, $address, $desc);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Tạo phòng ban mới thành công!');
}
function get_information_load_department($id_department)
{
    $conn = open_database();
    $count = count_employee_department($id_department);
    $sql = 'select * from department where idDepartment = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_department);
    $stm->execute();
    $result = $stm->get_result();
    $data = array_push($count, $result);
    return $result;
}
function count_employee_department($id_department)
{

    $conn = open_database();
    $sql = 'select nameDepartment from department where idDepartment = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_department);
    $stm->execute();
    $result = $stm->get_result();
    $result = implode($result->fetch_assoc());
    $sql1 = 'select count(position) from users where department = ?';
    $stm = $conn->prepare($sql1);
    $stm->bind_param('s', $result);
    $stm->execute();
    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    // $data = $count['count(*)'];
    return $count;
}
function update_department($name, $address, $desc, $id_department)
{
    if (check_department($name)) {
        return array('code' => 1, 'error' => 'Phòng ban này đã tồn tại');
    }
    $conn = open_database();
    $sql = 'update department set nameDepartment = ?, addressDepartment = ?, descDepartment = ? where idDepartment = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('sssi', $name, $address, $desc, $id_department);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Cập nhật phòng ban thành công!');
}
function load_employee_department($id_department)
{
    $conn = open_database();
    $nameDepartment = implode(get_department_byid($id_department));
    $sql = 'select username from users where department = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $nameDepartment);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    $result = $stm->get_result();
    while ($row[] = $result->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}
function promote_department($department, $user, $position)
{

    //kiểm tra bổ nhiệm hoặc bãi nhiệm trưởng phòng'

    if (($position == 'Manager') && check_manager_byid($department) == 1) {
        return array('code' => 3, 'error' => 'Hiện phòng ban này đã có trưởng phòng');
    }
    if ($position == 'Employee') {
        $rong = '';
        $sql = 'update department set manager = ?, status = 0 where idDepartment = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('si', $rong, $department);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
        }
        return array('code' => 0, 'error' => 'Bãi nhiệm trưởng phòng thành công!');
    }
    $sql = 'update department set manager = ?, status = 1  where idDepartment = ?';
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('si', $user, $department);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Bổ nhiệm trưởng phòng thành công!');
}
