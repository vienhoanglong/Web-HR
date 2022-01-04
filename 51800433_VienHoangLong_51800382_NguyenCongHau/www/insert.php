<?php
require_once('db.php');
$id = 'vienhoanglong';
$day = 3;
// $calendar = load_calendar_byid($id);
// $calendar = $calendar->fetch_assoc();
// $a = $calendar['ngayKetThuc'];
// $b = $calendar['ngayBatDau'];
// $user = $calendar['username'];
// print_r($user);
// $ngayBatDau = date("d-m-Y", strtotime($a));
// $ngayKetThuc = date("d-m-Y", strtotime($b));
// $dayoff = check_dayoff($ngayKetThuc, $ngayBatDau);

//print_r($calendar);
print_r(update_status_accept_calendar($id, $day));
