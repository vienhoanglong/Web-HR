<?php
session_start();
require_once('db.php');
$title_page = 'home';
if (!isset($_SESSION['user'])) {
	header('Location: login.php');
	exit();
}
if ($_SESSION['activated'] == 0) {
	header('Location: change_password.php');
	exit();
}
$user = $_SESSION['user'];
if ($_SESSION['role'] == 0) {
	$count_position = count_position();
	$count_user = count_user();
	$count_calendar = count_calendar();
}
if ($_SESSION['role'] == 1) {
	$count_task = count_task($user);
	$count_employee_of_deparment = count_employee_of_deparment($user);
	$count_calendar_department = count_calendar_department($user);
}
if ($_SESSION['role'] == 2) {
	$count_total_task = count_total_task($user);
	$count_complete_task = count_complete_task($user);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Trang chủ</title>
</head>

<body>
	<div class="wrapper">
		<?php include('includes/sidebar.php'); ?>
		<div id="content">
			<!-- Navbar -->
			<?php include('includes/navbar.php'); ?>
			<!-- Page Content  -->
			<div class="container-fluid">
				<div class="d-sm-flex">
					<h4 class="text-gray-800">Trang chủ</h4>
				</div>
			</div>
			<?php if ($_SESSION['role'] == 0) { ?>
				<div class="row ml-2 mr-2">
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Nhân Viên</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_user ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-users fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Phòng Ban</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"> <?= $count_position ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-briefcase fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Đơn xin nghỉ</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_calendar ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-calendar fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<!-- Trưởng phòng -->
			<?php if ($_SESSION['role'] == 1) { ?>
				<div class="row ml-2 mr-2">
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Tổng Nhân Viên</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_employee_of_deparment ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-users fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Đơn xin nghỉ</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_calendar_department ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-calendar fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											công việc đã giao</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_task ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-tasks fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if ($_SESSION['role'] == 2) { ?>
				<div class="row ml-2 mr-2">
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Công việc được giao</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_total_task ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-tasks fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4 mb-4">
						<div class="card shadow">
							<div class="card-body border-left-color">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
											Hoàn thành</div>
										<h5 class="mb-0 font-weight-bold text-gray-800"><?= $count_complete_task ?></h5>
									</div>
									<div class="col-auto">
										<i class="fa fa-tasks fa-2x text-orange"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script>
</body>

</html>