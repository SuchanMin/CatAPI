<?php
header("Content-Type: application/json; charset=UTF-8");
include "db_connect.php";

$sql = "SELECT * FROM CatBreeds WHERE is_visible=1";
$result = $conn->query($sql);

$cats = [];
while($row = $result->fetch_assoc()) {
    $cats[] = $row;
}

echo json_encode($cats, JSON_UNESCAPED_UNICODE);
?>