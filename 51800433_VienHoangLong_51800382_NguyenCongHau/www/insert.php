<?php
require_once('db.php');
$user = 'hoanglong';
$pass = '123456';
$newpass = '123456789';
$result = change_new_password($user, $pass, $newpass);
print_r($result);
