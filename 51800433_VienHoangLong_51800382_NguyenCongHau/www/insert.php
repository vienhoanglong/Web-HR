<?php
require_once('db.php');
$user = 'lehienluong';
$count_complete_task = count_complete_task($user);
print_r($count_complete_task);
