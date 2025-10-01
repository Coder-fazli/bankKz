<?php
require __DIR__ . '/wp-config.php';
$mysqli = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$mysqli) { echo "DB ERROR: ".mysqli_connect_errno()." - ".mysqli_connect_error(); exit; }
$r = $mysqli->query("SELECT 1 AS ok"); $row = $r ? $r->fetch_assoc() : null;
echo ($row && $row['ok']==1) ? "DB OK" : "DB QUERY FAIL";
