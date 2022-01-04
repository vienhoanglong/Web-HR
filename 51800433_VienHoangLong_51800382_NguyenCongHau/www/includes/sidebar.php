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
        <li class="<?php if ($page == 'home') {
                        echo 'active';
                    } ?>">
            <a href="/index.php"><i class="fa fa-home"></i>Trang chủ</a>
        </li>
        <li class="<?php if ($page == 'profile') {
                        echo 'active';
                    } ?>">
            <a href="/profile.php"><i class="fa fa-id-card-o"></i>Cá nhân</a>
        </li>
        <?php
        if ($_SESSION['role'] == 0) {
            echo
            '<li class=" ' ?>
            <?php if ($page == "management_employee") {
                echo "active";
            } ?>
            <?php echo '">' ?>
            <?php echo '<a href="/management_employee.php"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
            </li>' ?>
            <?php echo '
            <li class=" ' ?>
            <?php if ($page == "management_department") {
                echo "active";
            } ?>"
            <?php echo '>' ?>
            <?php echo '<a href="/management_department.php"> <i class="fa fa-briefcase"></i>Phòng ban</a>
             </li> ' ?>
            <?php echo '
            <li  class=" ' ?>
            <?php if ($page == "calendar_admin") {
                echo "active";
            } ?><?php echo '">' ?>
            <?php echo '<a href="/calendar_admin.php"><i class="fa fa-calendar"></i>Lịch</a>
            </li>'; ?><?php
                    }
                    if ($_SESSION['role'] == 1) {
                        echo
                        '<li class=" ' ?>
            <?php if ($page == "management_employee") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a href="/management_employee.php"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
            </li>' ?><?php echo '
            <li class=" ' ?>
            <?php if ($page == "calendar_manager") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a href="/calendar_manager.php"><i class="fa fa-calendar"></i>Lịch</a>
            </li>' ?><?php echo '
            <li class=" ' ?>
            <?php if ($page == "task_manager") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a href="/task_manager.php"> <i class="fa fa-tasks"></i>Task</a>
            </li>'; ?><?php
                    }
                    if ($_SESSION['role'] == 2) {
                        echo '<li class=" ' ?>
            <?php if ($page == "task_manager") {
                            echo "active";
                        } ?><?php echo '">' ?>
            <?php echo '<a href="/task_manager.php"> <i class="fa fa-tasks"></i>Task</a>
            </li>'; ?><?php
                    }
                        ?>

            <!-- <li>
            <a href="/management_employee.php"> <i class="fa fa-users"></i>Quản lý nhân viên</a>
        </li> -->
            <!-- <li>
            <a href="#"> <i class="fa fa-tasks"></i>Task</a>
        </li> -->
            <!-- <li>
            <a href="/management_department.php"> <i class="fa fa-briefcase"></i>Phòng ban</a>
        </li> -->
            <!-- <li>
            <a href="/calendar_employee.php"><i class="fa fa-calendar"></i>Lịch</a>
        </li> -->
            <li class="<?php if ($page == 'logout') {
                            echo 'active';
                        } ?>">
                <a href="/logout.php"><i class="fa fa-sign-out"></i>Thoát</a>
            </li>
    </ul>
</nav>