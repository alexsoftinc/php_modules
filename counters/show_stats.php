<?php
include_once 'admin/connect.php';
# установка кодировки 
@mysqli_query($db, 'set character_set_results = "utf8"');

$res = mysqli_query($db, "SELECT `views`, `hosts` FROM tbl_visits WHERE `date` = '$visit_date'");

$row = mysqli_fetch_assoc($res);

echo '<p>Уникальных посетителей за сегодня : <b>' . $row['hosts'] . '</b><br/>';
echo 'Просмотров за сегодня <b>' . $row['views'] . '</b></p>';
