<?php
include "db_connect.php";

/* ลบ */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM CatBreeds WHERE id=$id");
    header("Location: admin_list.php");
}

/* ซ่อน / แสดง */
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    mysqli_query($conn,
        "UPDATE CatBreeds SET is_visible = 1 - is_visible WHERE id=$id"
    );
    header("Location: admin_list.php");
}

/* อัปโหลดรูป */
$image = $_POST['old_image'] ?? "";

if (!empty($_FILES['image']['name'])) {
    $image = time()."_".$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
}

/* เพิ่ม / แก้ไข */
if (empty($_POST['id'])) {

    $sql = "INSERT INTO CatBreeds
    (name_th,name_en,description,characteristics,care_instructions,image_url,is_visible)
    VALUES (
        '{$_POST['name_th']}',
        '{$_POST['name_en']}',
        '{$_POST['description']}',
        '{$_POST['characteristics']}',
        '{$_POST['care_instructions']}',
        '$image',
        '{$_POST['is_visible']}'
    )";

} else {

    $sql = "UPDATE CatBreeds SET
        name_th='{$_POST['name_th']}',
        name_en='{$_POST['name_en']}',
        description='{$_POST['description']}',
        characteristics='{$_POST['characteristics']}',
        care_instructions='{$_POST['care_instructions']}',
        image_url='$image',
        is_visible='{$_POST['is_visible']}'
        WHERE id={$_POST['id']}";
}

mysqli_query($conn, $sql);
header("Location: admin_list.php");
