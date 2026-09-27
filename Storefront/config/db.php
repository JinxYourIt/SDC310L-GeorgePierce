<?php
require_once __DIR__ . '/../models/database.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = connect_db();
$conn->set_charset('utf8mb4');
