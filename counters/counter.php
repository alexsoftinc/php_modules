<?php
include_once 'admin/connect.php';
# установка кодировки 
@mysqli_query($db, 'set character_set_results = "utf8"');
# inside the client ip address
$user_ip    = $_SERVER['REMOTE_ADDR'];
$visit_date = date('Y-m-d');
# надо проверить заходил ли он сегодня если нет значит hit 
$result = mysqli_query($db, "SELECT visit_id FROM tbl_visits WHERE `date` = '$visit_date'") 
		or die("возникла проблема при запросе на получение информации о посетителе"); 
if(mysqli_num_rows($result) == 0)
{
	# clear table Ip address
	mysqli_query($db, "DELETE FROM tbl_ips");
	# insert new user for table )!
	mysqli_query($db, "INSERT INTO tbl_ips SET ip_address = '$user_ip'");
	# insert other information in some else table )_ date visit | or time 
	$res_count = mysqli_query($db, "INSERT INTO tbl_visits SET `date` = '$visit_date', `hosts` = 1, `views` = 1");
}
else
{
	$current_ip = mysqli_query($db, "SELECT ip_id FROM tbl_ips WHERE ip_address = '$user_ip'");
	# if IP wos today whe do it update tbl_visits and + params for column 'views'+1
	if(mysqli_num_rows($current_ip) == 1)
	{
		mysqli_query($db, "UPDATE tbl_visits SET `views` = `views`+1 WHERE date = '$visit_date'");
	}
	else 
	{
		# if not today this IPS addrres yet todo insert from table tbl_ips +1 visitor IP 
		mysqli_query($db, "INSERT INTO tbl_ips SET ip_address = '$current_ip'");
		mysqli_query($db, "UPDATE `tbl_visits` SET `hosts` = `hosts`+1, `views` = `views`+1 WHERE `date` = '$visit_date'");
	}
}
