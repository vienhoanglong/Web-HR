<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <h4>Manager Employee</h4>
        <strong>ME</strong>
    </div>
    <ul class="components">
        <li class="<?php if ($title_page == 'home') {
                        echo 'active';
                    } ?>">
            <a class="a_active" href="/index.php"><i class="fa fa-home"></i>Trang chủ</a>
        </li>
        <li class="<?php if ($title_page == 'profile') {
                        echo 'active';
                    } ?>">
            <a class="a_active" href="/profile.php"><i class="fa fa-id-card-o"></i>Cá nhân</a>
        </li>
        <?php
        if ($_SESSION['role'] == 0) {
            echo
            '<li class=" ' ?>
            <?php if ($title_page == "management_employee") {
                echo "active";
            } ?>
            <?php echo '">' ?>
            <?php echo '<a class="a_active" href="/management_employee.php"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
            </li>' ?>
            <?php echo '
            <li class=" ' ?>
            <?php if ($title_page == "management_department") {
                echo "active";
            } ?>"
            <?php echo '>' ?>
            <?php echo '<a class="a_active" href="/management_department.php"> <i class="fa fa-briefcase"></i>Phòng ban</a>
             </li> ' ?>
            <?php echo '
            <li  class=" ' ?>
            <?php if ($title_page == "calendar_admin") {
                echo "active";
            } ?><?php echo '">' ?>
            <?php echo '<a class="a_active "href="/calendar_admin.php"><i class="fa fa-calendar"></i>Lịch</a>
            </li>'; ?><?php
                    }
                    if ($_SESSION['role'] == 1) {
                        echo
                        '<li class=" ' ?>
            <?php if ($title_page == "management_employee") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a class="a_active" href="/management_employee.php"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
            </li>' ?><?php echo '
            <li class=" ' ?>
            <?php if ($title_page == "calendar_manager") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a class="a_active" href="/calendar_manager.php"><i class="fa fa-calendar"></i>Lịch</a>
            </li>' ?>
            <?php echo '
            <li class=" ' ?>
            <?php if ($title_page == "task") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a class="a_active" href="/task.php"> <i class="fa fa-tasks"></i>Task</a>
            </li>'; ?><?php
                    }
                    if ($_SESSION['role'] == 2) {
                        echo '<li class=" ' ?>
            <?php if ($title_page == "task") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a class="a_active" href="/task.php"> <i class="fa fa-tasks"></i>Task</a>
            </li>'; ?>
            <li class=" ' ?>
            <?php if ($title_page == "calendar_employee") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a class="a_active" href="/calendar_employee.php"> <i class="fa fa-calendar"></i>Lịch</a>
            </li>'; ?>



        <?php
                    }
        ?>
        <li class=" <?php if ($title_page == 'logout') {
                        echo 'active';
                    } ?>">
                <a class="a_active" href="/logout.php"><i class="fa fa-sign-out"></i>Thoát</a>
            </li>
    </ul>
</nav>