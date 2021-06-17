<?php
date_default_timezone_set('UTC');
#Databases setup for the beta instance
$host = getenv('DATABASE_HOST');
$database = getenv('DATABASE_NAME');
$db_user = getenv('DATABASE_USER');
$db_passwd = getenv('DATABASE_PASS');
#Connection setup
#Mysql connection and testing
$link = mysqli_connect($host, $db_user, $db_passwd, $database);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$versionnumber = "prod";
$logo_name = "realistic_logo.png"

?>
