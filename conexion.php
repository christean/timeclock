<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/* php 5.5*/
$hostname = "localhost";
$database = "geofel";
$username = "root";
$password = "root";
$con =  mysql_connect($hostname, $username, $password);
mysql_select_db($database,$con);
if (!$con) {
    die('No pudo conectarse: ' . mysql_error());
}


/*
$hostname = "localhost";
$database = "grupo_sizek";
$username = "sag";
$password = "sag";
$con =  mysqli_connect($hostname, $username, $password);
mysqli_select_db($con, $database);
if (!$con) {
    die('No pudo conectarse: ' . mysqli_error());
}else{
	//echo "conectado";
}
*/
?> 