<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/* php 5.5*/
$hostname = "$host";
$database = "$db";
$username = "$user";
$password = "$pwd";
$con =  mysql_connect($hostname, $username, $password);
mysql_select_db($database,$con);
if (!$con) {
    die('No pudo conectarse: ' . mysql_error());
}
?> 
