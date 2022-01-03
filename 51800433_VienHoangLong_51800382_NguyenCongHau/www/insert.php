<?php
require_once('db.php');
// // $user = 'hoanglong';
// // $pass = '123456';
// // $newpass = '123456789';
// // $result = change_new_password($user, $pass, $newpass);
// // print_r($result);
$id_department = 3;
$user = "nguyenconghau";
$position = "Manager";
// $result = promote_department($id_department, $user, $position);
// print_r($result);
print_r(promote_department($id_department, $user, $position));
