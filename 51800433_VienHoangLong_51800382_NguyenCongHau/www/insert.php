<?php
require_once('db.php');
$ud_employee_id = 45;
$data = [];
$result = get_information_update_employee($ud_employee_id);
if (mysqli_fetch_assoc($result) > 0) {
    foreach ($result as $row) {
        array_push($data, $row);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
