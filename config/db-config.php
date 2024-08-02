<?php

$domain_name = 'http://127.0.0.1/Meta-X';

// declare mysql database connection variables
$db_name = 'meta_x';
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';

// create db connection
$db_con =new mysqli($db_host,$db_user,$db_password,$db_name);

//db connection status check
if($db_con->connect_error){
header("location:$domain_name/errors.php?emsg=DB Connect Error");
}

// set timezone to Srilanka
date_default_timezone_set('Asia/Colombo');
$lk_date_time = date('Y-m-d H:i:s',time());

?>