<h2>Слабовесная система статистики (учёт посетителей)</h2>
<?php
include_once 'connect.php';

# установка кодировки 
@mysqli_query($db, 'set character_set_results = "utf8"');

$res = mysqli_query($db, "SELECT * FROM tbl_visits ORDER BY `visit_id` DESC");

$row = mysqli_fetch_assoc($res);

echo '<p>Уникальных посетителей за сегодня : <b>' . $row['hosts'] . '</b><br/>';
echo 'Просмотров за сегодня <b>' . $row['views'] . '</b></p>';
?>
<hr>
