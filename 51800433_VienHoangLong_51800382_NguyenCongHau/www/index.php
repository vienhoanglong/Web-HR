<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Home Page</title>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="active">
			<div class="sidebar-header">
				<h4>Manager Employee</h4>
				<strong>ME</strong>
			</div>
			<ul class="components">
				<li class="active">
					<a href="#"><i class="fa fa-home"></i>Trang chủ</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-id-card-o"></i>Cá nhân</a>
				</li>
				<li>
					<a href="#"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
				</li>
				<li>
					<a href="#"> <i class="fa fa-tasks"></i>Task</a>
				</li>
				<li>
					<a href="#"> <i class="fa fa-briefcase"></i>Phòng ban</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-calendar"></i>Lịch</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-sign-out"></i>Thoát</a>
				</li>
			</ul>
		</nav>
		<div id="content">
			<!-- Navbar -->
			<nav class="navbar navbar-inverse navbar-light bg-white">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" id="sidebar-collapse" class="btn navbar-btn">
							<i class="fa fa-bars"></i>
						</button>
					</div>
					<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
						<div class="input-group">
							<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
							<div class="input-group-append">
								<button class="btn text-orange" type="button">
									<i class="fa fa-search fa-sm"></i>
								</button>
							</div>
						</div>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item item-notification">
							<a href="#"><i class="fa fa-bell text-orange"></i></a>
						</li>
						<li class="nav-item item-username"><a href="#">Viên Hoàng Long</a></li>
						<img class="img-profile rounded-circle" src="/images/avt.jpeg">
					</ul>
				</div>
			</nav>
			<!-- Page Content  -->
			<div class="container-fluid">
				<div class="d-sm-flex justify-content-between">
					<h4 class="text-gray-800">Trang chủ</h4>
				</div>
			</div>

			<div class="row ml-2 mr-2">
				<div class="col-xl-9 col-lg-7">
					<div class="card shadow mb-4">
						<!-- Card Body -->
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Bảng Danh Sách Nhân Viên</h6>
						</div>
						<div class="card-body">
							<div class="form-outline mb-2">
								<input type="search" class="form-control" placeholder="Search..." />

							</div>
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Mã nhân viên</th>
											<th>Họ Tên</th>
											<th>Chức vụ</th>
											<th>Phòng Ban</th>
											<th>Function</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>NV01</td>
											<td>Viên Hoàng Long</td>
											<td>Trưởng phòng CNTT</td>
											<td>Phòng CNTT</td>
											<td>
												<a class="btn btn-primary btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-edit"></i></span>
													<span>Edit</span>
												</a>
												<a class="btn btn-danger btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-remove"></i></span>
													<span>Delete</span>
												</a>
											</td>
										</tr>
										<tr>
											<td>NV01</td>
											<td>Viên Hoàng Long</td>
											<td>Trưởng phòng CNTT</td>
											<td>Phòng CNTT</td>
											<td>
												<a class="btn btn-primary btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-edit"></i></span>
													<span>Edit</span>
												</a>
												<a class="btn btn-danger btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-remove"></i></span>
													<span>Delete</span>
												</a>
											</td>
										</tr>
										<tr>
											<td>NV01</td>
											<td>Viên Hoàng Long</td>
											<td>Nhân viên phòng CNTT</td>
											<td>Phòng CNTT</td>
											<td>
												<a class="btn btn-primary btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-edit"></i></span>
													<span>Edit</span>
												</a>
												<a class="btn btn-danger btn-icon-split">
													<span class="icon text-white-50"><i class="fa fa-remove"></i></span>
													<span>Delete</span>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
								<ul class="pagination">
									<li class="page-item"><a class="page-link" href="#">Trước</a></li>
									<li class="page-item active"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item"><a class="page-link" href="#">4</a></li>
									<li class="page-item"><a class="page-link" href="#">5</a></li>
									<li class="page-item"><a class="page-link" href="#">Sau</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3">
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Danh sách thông báo</h6>
						</div>
						<div class="card-body">
							<!-- Content notification -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script>
</body>

</html>