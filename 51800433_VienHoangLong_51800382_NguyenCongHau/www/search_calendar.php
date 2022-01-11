<?php
require_once('db.php');
if (isset($_POST['search_calendar'])) {
    $search_calendar = $_POST['search_calendar'];
    $calendar = search_calendar($search_calendar);
}
?>
<table class="table table-bordered text-center table-hover" id="table-calendar" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mã nghỉ phép</th>
            <th>Nhân viên</th>
            <th>Yêu cầu</th>
            <th>Thời gian</th>
            <th>Lí do</th>
            <th>Phê duyệt</th>
        </tr>
    </thead>
    <?php
    while ($row = mysqli_fetch_assoc($calendar)) { ?>
        <tbody>
            <tr>
                <td id="id_calendar_admin"><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= check_dayoff($row['ngayBatDau'], $row['ngayKetThuc']) ?> ngày</td>
                <td><?= date('d/m/Y', strtotime($row['ngayBatDau'])) . '-' . date('d/m/Y', strtotime($row['ngayKetThuc'])) ?></td>
                <td>
                    <a class="btn click-detail-calender text-primary">Chi tiết<a>
                </td>
                <td>
                    <?php
                    if ($row['trangThai'] == 'Chờ duyệt') {
                        echo '<a class="btn btn-success btn-icon-split click-accept-calender">
                                                    <span class="icon text-white-100"><i class="fa fa-check"></i></span>
                                                    </a>
                                                    <a class="btn btn-danger btn-icon-split click-cancel-calender">
                                                        <span class="icon text-white-100"><i class="fa fa-times"></i></span>
                                                    </a>';
                    } elseif ($row['trangThai'] == 'Đã duyệt') {
                        echo '<span class="text alert-success font-weight-bold">Đã duyệt</span>';
                    } else {
                        echo '<span class="text alert-danger font-weight-bold">Không duyệt</span>';
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    <?php } ?>
</table>