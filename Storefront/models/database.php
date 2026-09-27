<?php
function connect_db() {
    // Reuse the connection during this request.
    static $conn = null;

    if ($conn === null) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "catalog_db";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, 'utf8mb4');
    }

    return $conn;
}
