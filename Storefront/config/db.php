<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "catalog_db";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn){
    die("Datatbase connection failure: " . mysqli_connect_error());
}
?>