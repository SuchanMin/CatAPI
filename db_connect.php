<?php
  $host = 'localhost';
  $db = 'it67040233124';
  $pass = 'M3T5E7V9';
  $dbname = 'it67040233124';

  $conn = new mysqli($host, $db, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("เชื่อมต่อไม่สำเร็จ: " . $conn->connect_error);
}

?>
