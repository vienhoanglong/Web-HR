<?php
session_start();
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
    <title>Quản lý nhân viên</title>
</head>

<body>
    <div class="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content">
            <!-- Navbar -->
            <?php include('includes/navbar.php'); ?>
            <!-- Page Content  -->
            <div class="container-fluid">
                <div class="col-xl-12 col-lg-9">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-header py-3">
                            <h4 class="font-weight-bold text-primary">Bảng Danh Sách Nhân Viên</h4>
                            <div class="click-create-employee">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Create Employee</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-outline mb-2">
                                <input type="search" class="form-control" placeholder="Search..." />

                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã nhân viên</th>
                                            <th>Họ Tên</th>
                                            <th>Chức vụ</th>
                                            <th>Phòng Ban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>NV01</td>
                                            <td><a href="#" class="font-weight-bold">Viên Hoàng Long</a></td>
                                            <td>Trưởng phòng CNTT</td>
                                            <td>Phòng CNTT</td>
                                            <td>
                                                <a class="btn btn-primary btn-icon-split click-update-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                                <a class="btn btn-info btn-icon-split click-reset-password">
                                                    <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                    <span>Pass</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NV01</td>
                                            <td><a href="#" class="font-weight-bold">Viên Hoàng Long</a></td>
                                            <td>Trưởng phòng CNTT</td>
                                            <td>Phòng CNTT</td>
                                            <td>
                                                <a class="btn btn-primary btn-icon-split click-update-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                                <a class="btn btn-info btn-icon-split click-reset-password">
                                                    <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                    <span>Pass</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NV01</td>
                                            <td><a href="#" class="font-weight-bold">Viên Hoàng Long</a></td>
                                            <td>Trưởng phòng CNTT</td>
                                            <td>Phòng CNTT</td>
                                            <td>
                                                <a class="btn btn-primary btn-icon-split click-update-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                                <a class="btn btn-info btn-icon-split click-reset-password">
                                                    <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                    <span>Pass</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NV01</td>
                                            <td><a href="#" class="font-weight-bold">Viên Hoàng Long</a></td>
                                            <td>Trưởng phòng CNTT</td>
                                            <td>Phòng CNTT</td>
                                            <td>
                                                <a class="btn btn-primary btn-icon-split click-update-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                                <a class="btn btn-info btn-icon-split click-reset-password">
                                                    <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                    <span>Pass</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NV01</td>
                                            <td><a href="#" class="font-weight-bold">Viên Hoàng Long</a></td>
                                            <td>Trưởng phòng CNTT</td>
                                            <td>Phòng CNTT</td>
                                            <td>
                                                <a class="btn btn-primary btn-icon-split click-update-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-edit"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-danger btn-icon-split click-delete-employee">
                                                    <span class="icon text-white-50"><i class="fa fa-trash"></i></span>
                                                    <span>Delete</span>
                                                </a>
                                                <a class="btn btn-info btn-icon-split click-reset-password">
                                                    <span class="icon text-white-50"><i class="fa fa-repeat"></i></span>
                                                    <span>Pass</span>
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
        <!-- Dialog create employee-->
        <div id="create-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm nhân viên mới</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="fulname">Họ và tên</label>
                                <input name="fullname" class="form-control" type="text" placeholder="Full name" id="fullname">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                            </div>
                            <div class="form-group">
                                <label for="position">Chức vụ</label>
                                <select class="form-control" id="position">
                                    <option>Nhân viên</option>
                                    <option>Trưởng phòng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Phòng ban</label>
                                <select class="form-control" id="department">
                                    <option>Phòng tài chính</option>
                                    <option>Phòng marketing</option>
                                    <option>Phòng kết toán</option>
                                    <option>Phòng nhân sự</option>
                                    <option>Phòng CNTT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" class="form-control" type="text" placeholder="email123@example.com" id="email">
                            </div>

                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn br-color">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Dialog update employee -->
        <div id="update-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="myForm" method="">
                        <div class="modal-header">
                            <h5 class="modal-title">Chỉnh sửa nhân viên mới</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id">Mã nhân viên</label>
                                <input name="id" class="form-control" type="text" id="id" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fulname">Họ và tên</label>
                                <input name="fullname" class="form-control" type="text" placeholder="Full name" id="fullname">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" class="form-control" type="text" placeholder="User name" id="username">
                            </div>
                            <div class="form-group">
                                <label for="position">Chức vụ</label>
                                <select class="form-control" id="position">
                                    <option>Nhân viên</option>
                                    <option>Trưởng phòng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Phòng ban</label>
                                <select class="form-control" id="department">
                                    <option>Phòng tài chính</option>
                                    <option>Phòng marketing</option>
                                    <option>Phòng kết toán</option>
                                    <option>Phòng nhân sự</option>
                                    <option>Phòng CNTT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" class="form-control" type="text" placeholder="email123@example.com" id="email">
                            </div>

                        </div>
                        <div class="modal-footer pull-left">
                            <button type="button" class="btn br-color" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn br-color">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Dialog delete employee -->
        <div id="delete-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Xóa nhân viên</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn xóa nhân viên <strong>Viên Hoàng Long</strong> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dialog re-password employee -->
        <div id="re-password-employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <hp class="modal-title">Reset mật khẩu nhân viên</hp>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn reset mật khẩu về mặc định ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger">Yes</button>
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