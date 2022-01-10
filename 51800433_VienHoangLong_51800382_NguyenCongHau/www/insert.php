<?php
require_once('db.php');

$num_row = get_calendar();
$num_row_calendar = (mysqli_num_rows($num_row));
$total_page = ceil($num_row_calendar / $num_per_page);

if ($page > 1) {
    echo "
    <li class='page-item'>
        <a class='page-link' href='calendar_admin.php?page=" . ($page - 1) . "'>Trước</a>
    </li>";
}
for ($i = 1; $i < $total_page; $i++) {
    echo "
    <li class='page-item active'>
        <a class='page-link' href='calendar_admin.php?page=" . $i . "'>$i</a>
    </li>";
}
if ($i > $page) {
    echo "
    <li class='page-item'>
        <a class='page-link' href='calendar_admin.php?page=" . ($page + 1) . "'>Sau</a>
    </li>";
}
?>
<?php
    if($page>1){?>
    <li class="page-item active">
        <a class="page-link" href="calendar_admin.php?page=<?=($page-1)?> ">Trước</a>
    </li>
    <?php } ?>
    <?php
    for($i = 1; $i<$total_page; $i++){?>
        <li class="page-item"><a class="page-link" href="calendar_admin.php?page=<?=$i?>"><?=$i?></a></li>
    <?php } ?>
    <?php
    if($i>$page){?>
    <li class="page-item active">
        <a class="page-link" href="calendar_admin.php?page=<?=($page+1)?> ">Sau</a>
    </li>
    <?php } ?>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item"><a class="page-link" href="#">4</a></li>
<li class="page-item"><a class="page-link" href="#">5</a></li>