<?php
date_default_timezone_set('UTC');
#Databases setup for the beta instance
$host = "localhost";
$database = "ans_inv_peter_dev";
$db_user = "peter";
$db_passwd = "qwelkj123";
#Connection setup
#Mysql connection and testing
$link = mysqli_connect($host, $db_user, $db_passwd, $database);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$versionnumber = "Peter_dev";

?>
