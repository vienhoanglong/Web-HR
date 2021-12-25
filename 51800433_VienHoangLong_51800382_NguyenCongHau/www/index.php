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
				<div class="d-sm-flex justify-content-between">
					<h4 class="text-gray-800">Trang chủ</h4>
				</div>
			</div>
			<div class="row ml-2 mr-2">
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card shadow h-80">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col mr-2">
									<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
										Nhân Viên</div>
									<h5 class="mb-0 font-weight-bold text-gray-800">10,000</h5>
								</div>
								<div class="col-auto">
									<i class="fa fa-users fa-2x text-orange"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card shadow h-80">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col mr-2">
									<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
										Phòng Ban</div>
									<h5 class="mb-0 font-weight-bold text-gray-800">10,000</h5>
								</div>
								<div class="col-auto">
									<i class="fa fa-briefcase fa-2x text-orange"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card shadow h-80">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col mr-2">
									<div class="text-xs text-uppercase font-weight-bold text-orange mb-1">
										Ngày Nghỉ</div>
									<h5 class="mb-0 font-weight-bold text-gray-800">40</h5>
								</div>
								<div class="col-auto">
									<i class="fa fa-calendar fa-2x text-orange"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ml-2 mr-2">
				<div class="col-xl-12 col-lg-9">
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
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script>
</body>

</html>