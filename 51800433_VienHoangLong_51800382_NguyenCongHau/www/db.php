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
function get_fullname($user)
{
    $conn = open_database();
    $sql = 'select fullname from users where username = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
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
    if (($position === 'Manager') && check_manager_byid($department) == '1') {
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
    //Tạo nghỉ trong năm cho nhân viên
    create_accept_calender($user, $role);
    return array('code' => 0, 'error' => 'Tạo nhân viên mới thành công!');
}
function load_employee($start_from, $num_per_page)
{
    $conn = open_database();
    $sql = 'select * from users where role between ? and ? limit ?, ?';
    $role1 = 1;
    $role2 = 2;
    $stm = $conn->prepare($sql);
    $stm->bind_param('iiii', $role1, $role2, $start_from, $num_per_page);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
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
    //$data = array_push($count, $result);
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
    if (($position == 'Manager') && check_manager_byid($department) === '1') {
        return array('code' => 3, 'error' => 'Hiện phòng ban này đã có trưởng phòng');
    }
    if ($position == 'Employee') {
        $sql = 'update department set manager = "", status = 0 where idDepartment = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('i', $department);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
        }
        $sql1 = "update users set role = 2, position = 'Employee' where username = ?";
        $stm1 = $conn->prepare($sql1);
        $stm1->bind_param('s', $user);
        if (!$stm1->execute()) {
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
    //Update users
    $sql1 = "update users set role = 1, position = 'Manager' where username = ?";
    $stm1 = $conn->prepare($sql1);
    $stm1->bind_param('s', $user);
    if (!$stm1->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Bổ nhiệm trưởng phòng thành công!');
}
//check số ngày nghỉ
function calendar_rest($user)
{
    $conn = open_database();
    $sql = 'select ngayConLai from accept_calendar where username = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
    return $data;
}
//Kiểm tra ngày nghỉ còn lại 
function check_dayoff($ngayBatDau, $ngayKetThuc)
{
    $diff = abs(strtotime($ngayKetThuc) - strtotime($ngayBatDau));
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    return $days;
}
//create đơn xin nghỉ phép
function create_calendar($username, $position, $department, $ngayBatDau, $ngayKetThuc, $liDo, $ngayConLai)
{
    if (check_dayoff($ngayBatDau, $ngayKetThuc) >= $ngayConLai) {
        return array('code' => 1, 'error' => 'Ngày nghỉ đã vượt quá giới hạn');
    }
    $ngayBatDau1 = date("Y-m-d", strtotime($ngayBatDau));
    $ngayKetThuc1 = date("Y-m-d", strtotime($ngayKetThuc));
    $conn = open_database();
    $sql = 'insert into calendar(username, position, department, ngayBatDau, ngayKetThuc, liDo) values(?, ?, ?, ?, ?, ?)';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssssss', $username, $position, $department, $ngayBatDau1, $ngayKetThuc1, $liDo);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Tạo phòng ban mới thành công!');
}
//create accept_calendar
function create_accept_calender($user, $role)
{
    $conn = open_database();
    $ngayConLai = ($role === 1) ? 15 : 12;
    $sql = 'insert into accept_calendar(username, ngayConLai) values (?,?)';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $user, $ngayConLai);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Tạo thành công!');
}
//
function get_calendar()
{
    $conn = open_database();
    $sql = 'select * from calendar';
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function get_calendar_employee()
{
    $conn = open_database();
    $position = "Employee";
    $sql = 'select * from calendar where position = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $position);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
//tìm kiếm calendar
function search_calendar($search_calendar)
{
    $conn = open_database();
    $sql = "select * from calendar where concat(username, id, ngayBatDau, ngayKetThuc, liDo) like '%$search_calendar%' order by thoiGianTao desc";
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function load_calendar($start_from, $num_per_page)
{
    $conn = open_database();
    $position = "Manager";
    $sql = 'select * from calendar where position = ? order by thoiGianTao desc limit ?, ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('sii', $position, $start_from, $num_per_page);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function load_calendar_employee($start_from, $num_per_page, $department)
{
    $conn = open_database();
    $position = "Employee";
    $sql = 'select * from calendar where position = ? and department = ? order by thoiGianTao desc limit ?, ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssii', $position, $department, $start_from, $num_per_page);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
//load calendar by id
function load_calendar_byid($id)
{
    $conn = open_database();
    $sql = 'select * from calendar where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}
function load_calendar_byuser($id)
{
    $conn = open_database();
    $sql = 'select username from calendar where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id);
    $stm->execute();
    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
    return $data;
}
function load_accept_calendar()
{
    $conn = open_database();
    $sql = 'select * from accept_calendar';
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
function load_result_calendar_employee($user)
{
    $conn = open_database();
    $sql = 'select * from calendar where username = ? order by thoiGianTao desc';
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function load_result_calendar($user, $start_from, $num_per_page)
{
    $conn = open_database();
    $sql = 'select * from calendar where username = ? order by thoiGianTao desc limit ?, ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('sii', $user, $start_from, $num_per_page);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function update_status_accept_calendar($id_calendar, $user, $dayoff)
{
    //cập nhật status và chèn dữ liệu vào calendar
    $conn = open_database();
    $sql = 'update accept_calendar set ngayDaNghi = (ngayDaNghi + ?), ngayConLai = (ngayConLai - ?) where username = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('sss', $dayoff, $dayoff, $user);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    $conn = open_database();
    $trangThai = 'Đã duyệt';
    $sql1 = 'update calendar set trangThai = ? where id = ?';
    $stm1 = $conn->prepare($sql1);
    $stm1->bind_param('ss', $trangThai, $id_calendar);
    if (!$stm1->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Duyệt đơn thành công!');
}
function update_status_cancel_calendar($id_calendar)
{
    $conn = open_database();
    $trangThai = 'Không duyệt';
    $sql = 'update calendar set trangThai = ? where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('si', $trangThai, $id_calendar);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Thực hiện không duyệt đơn thành công!');
}
//Task
// Lấy danh sách nhân viên thuộc phòng ban
function get_list_employee_department($department)
{
    $conn = open_database();
    $role = 2;
    $sql = 'select username, fullname from users where department = ? and role = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('si', $department, $role);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    while ($row[] = $result->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}
//Tạo công việc
function create_new_task($name_manager, $name_employee, $department, $name_task, $desc_task, $file, $deadline)
{
    //xử lý file
    $uploadDir = 'uploads/task/';
    $fileName = basename($file['name']);
    $size = $file['size'];
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array(
        'gif', 'jpg', 'jpeg', 'txt', 'zip', 'rar', 'png', 'doc', 'pdf', 'mp3', 'mp4', 'pptx', 'docx', 'xlsx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', ''
    );
    if (!in_array($fileType, $allowTypes)) {
        return array('code' => 3, 'error' => 'Định dạng file này không được hỗ trợ, vui lòng chọn định dạng khác');
    } elseif ($size >= 100 * 1024 * 1024) {
        return array('code' => 4, 'error' => 'Kích thước file không được vượt quá 100MB');
    } else {
        //upload file
        move_uploaded_file($file['tmp_name'], $targetFilePath);
        $conn = open_database();
        $status = 'New';
        $sql = 'insert into list_task(name_manager, name_employee, department, name_task, desc_task, status, file, deadline) values(?,?,?,?,?,?,?,?)';
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssssss', $name_manager, $name_employee, $department, $name_task, $desc_task, $status, $fileName, $deadline);
        if (!$stm->execute()) {
            //die('Query error: ' . $stm->error);
            return array('code' => 2, 'error' => 'Lệnh không thực hiện được');
        }
        return array('code' => 0, 'error' => 'Tạo công việc thành công!');
    }
}
//
function get_deadline_task($id_task)
{
    $conn = open_database();
    $sql = 'select deadline from list_task where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_task);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = implode($result->fetch_assoc());
    return $data;
}
//Kiểm tra thời gian nộp
function check_time_submit($deadline, $time_submit)
{
    if (strtotime($time_submit) <= strtotime($deadline)) {
        $result = 'Turn in';
    } else {
        $result = 'Turn in late';
    }
    return $result;
}
//Load task
function load_task()
{
    $conn = open_database();
    $sql = 'select * from list_task order by time_created desc';
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
//Load task by id
function load_task_byid($id)
{
    $conn = open_database();
    $sql = 'select * from list_task where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
//Load task được giao
function load_task_employee($name_employee)
{
    $conn = open_database();
    $status = 'Canceled';
    $sql = 'select * from list_task where name_employee = ? and status != ? order by time_created desc';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $name_employee, $status);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    return $result;
}
//Update status task
function update_status_task($id, $status)
{
    $conn = open_database();
    $sql = 'update list_task set status = ? where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('si', $status, $id);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Cập nhật trạng thái thành công!');
}
//Update status và gia hạn deadlien
function update_deadline_task($id, $status, $deadline)
{
    $conn = open_database();
    $sql = 'update list_task set status = ?, deadline = ? where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssi', $status, $deadline, $id);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Cập nhật trạng thái thành công!');
}
//Submit kết quả công việc của nhân viên
function submit_task($task_id, $desc, $user, $file)
{

    $uploadDir = 'uploads/submit/';
    $fileName = basename($file['name']);
    $size = $file['size'];
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array(
        'gif', 'jpg', 'jpeg', 'txt', 'zip', 'rar', 'png', 'doc', 'pdf', 'mp3', 'mp4', 'pptx', 'docx', 'xlsx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', ''
    );
    if (!in_array($fileType, $allowTypes)) {
        return array('code' => 3, 'error' => 'Định dạng file này không được hỗ trợ, vui lòng chọn định dạng khác');
    } elseif ($size >= 100 * 1024 * 1024) {
        return array('code' => 4, 'error' => 'Kích thước file không được vượt quá 100MB');
    } else {
        move_uploaded_file($file['tmp_name'], $targetFilePath);
        $conn = open_database();
        //Kiểm tra trạng thái nộp
        $deadline = get_deadline_task($task_id);
        $today = date('Y-m-d H:i:s');
        $submit_status = check_time_submit($deadline, $today);
        $sql = 'insert into task_process(task_id, comment, user, file_submit, submit_status) values(?,?,?,?,?)';
        $stm = $conn->prepare($sql);
        $stm->bind_param('issss', $task_id, $desc, $user, $fileName, $submit_status);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
        }
        $status = 'Waiting';
        update_status_task($task_id, $status);
        return array('code' => 0, 'error' => 'Submit công việc thành công!');
    }
}
//Load kết quả submit của nhân viên
function history_task($id_task)
{
    $conn = open_database();
    $sql = 'select * from task_process where task_id = ? order by time_submit desc';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_task);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    return $result;
}
//Lấy user trong task_process
// function get_user_task($id_task){
//     $conn = open_database();
//     $sql = 'select user from task_process where task_id = ?';
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('i', $id_task);
//     if (!$stm->execute()) {
//         die('Query error: ' . $stm->error);
//     }
//     $result = $stm->get_result();
//     $data = implode($result->fetch_assoc());
//     return $data;
// }
// function check_manager_task($user){
//     $sql = 'select role from users where username = ?';
//     $conn = open_database();

//     $stm = $conn->prepare($sql);
//     $stm->bind_param('s', $name);
//     if (!$stm->execute()) {
//         die('Query error: ' . $stm->error);
//     }
//     $result = $stm->get_result();
//     if ($result->num_rows > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }
function submit_task_new($id_task)
{
    $conn = open_database();
    $sql = 'select * from task_process where task_id = ? order by time_submit desc';
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id_task);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
//Reject task 
function reject_task($task_id, $desc, $user, $file, $deadline)
{
    $uploadDir = 'uploads/submit/';
    $fileName = basename($file['name']);
    $size = $file['size'];
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array(
        'gif', 'jpg', 'jpeg', 'txt', 'zip', 'rar', 'png', 'doc', 'pdf', 'mp3', 'mp4', 'pptx', 'docx', 'xlsx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', ''
    );
    if (!in_array($fileType, $allowTypes)) {
        return array('code' => 3, 'error' => 'Định dạng file này không được hỗ trợ, vui lòng chọn định dạng khác');
    } elseif ($size >= 100 * 1024 * 1024) {
        return array('code' => 4, 'error' => 'Kích thước file không được vượt quá 100MB');
    } else {
        move_uploaded_file($file['tmp_name'], $targetFilePath);
        $conn = open_database();
        $submit_status = 'Manager reject';
        $sql = 'insert into task_process(task_id, comment, user, file_submit, submit_status) values(?,?,?,?, ?)';
        $stm = $conn->prepare($sql);
        $stm->bind_param('issss', $task_id, $desc, $user, $fileName, $submit_status);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
        }
        $status = 'Rejected';
        if ($deadline != null) {
            update_deadline_task($task_id, $status, $deadline);
            return array('code' => 0, 'error' => 'Reject công việc thành công!');
        } else {
            update_status_task($task_id, $status);
            return array('code' => 0, 'error' => 'Reject công việc thành công!');
        }
    }
}
//Update task
function update_task($task_id, $title, $desc, $deadline, $file, $fileold)
{
    $uploadDir = 'uploads/submit/';
    $fileName = basename($file['name']);
    $size = $file['size'];
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array(
        'gif', 'jpg', 'jpeg', 'txt', 'zip', 'rar', 'png', 'doc', 'pdf', 'mp3', 'mp4', 'pptx', 'docx', 'xlsx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', ''
    );
    if (!in_array($fileType, $allowTypes)) {
        return array('code' => 3, 'error' => 'Định dạng file này không được hỗ trợ, vui lòng chọn định dạng khác');
    } elseif ($size >= 100 * 1024 * 1024) {
        return array('code' => 4, 'error' => 'Kích thước file không được vượt quá 100MB');
    } else {
        move_uploaded_file($file['tmp_name'], $targetFilePath);
        $file_update = ($fileName != '') ? $fileName : $fileold;
        $conn = open_database();
        $sql = 'update list_task set name_task = ?, desc_task =?, deadline = ?, file = ? where id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssi', $title, $desc, $deadline, $file_update, $task_id);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
        }
        return array('code' => 0, 'error' => 'Cập nhật thành công!');
    }
}
//Complete task
function complete_task($id_task, $rating)
{
    $conn = open_database();
    $status = 'Completed';
    $sql = 'update list_task set rating = ?, status = ? where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssi', $rating, $status, $id_task);
    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Không thể thực hiện lệnh!');
    }
    return array('code' => 0, 'error' => 'Complete thành công!');
}
