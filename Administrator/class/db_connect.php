<?php /*
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ngaliya_db');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);*/
$conn = new mysqli('localhost', 'root', '', 'ngaliya_db');

if($conn === false){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>