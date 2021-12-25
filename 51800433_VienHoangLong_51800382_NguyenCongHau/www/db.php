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
