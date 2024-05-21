<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "db_pendaftaran";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
