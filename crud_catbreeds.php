<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "db_connect.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // ==========================
    // GET (ทั้งหมด หรือ ตาม id)
    // ==========================
    case 'GET':

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM CatBreeds WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            $sql = "SELECT * FROM CatBreeds";
            $result = mysqli_query($conn, $sql);

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        }

        break;


    // ==========================
    // POST (เพิ่ม / แก้ไข)
    // ==========================
    case 'POST':

        $id = $_POST['id'] ?? '';
        $name_th = $_POST['name_th'];
        $name_en = $_POST['name_en'];
        $description = $_POST['description'];
        $characteristics = $_POST['characteristics'];
        $care_instructions = $_POST['care_instructions'];
        $is_visible = $_POST['is_visible'];

        // ======================
        // จัดการ Upload รูป
        // ======================
        $image_name = $_POST['old_image'] ?? '';

        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . "_" . $_FILES['image']['name'];
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                "Cat/" . $image_name
            );
        }

        if ($id == "") {
            // INSERT
            $sql = "INSERT INTO CatBreeds
            (name_th, name_en, description, characteristics,
             care_instructions, image_url, is_visible)
            VALUES
            ('$name_th','$name_en','$description',
             '$characteristics','$care_instructions',
             '$image_name','$is_visible')";
        } else {
            // UPDATE
            $id = intval($id);
            $sql = "UPDATE CatBreeds SET
                name_th='$name_th',
                name_en='$name_en',
                description='$description',
                characteristics='$characteristics',
                care_instructions='$care_instructions',
                image_url='$image_name',
                is_visible='$is_visible'
                WHERE id=$id";
        }

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }

        break;


    // ==========================
    // DELETE
    // ==========================
    case 'DELETE':

        parse_str(file_get_contents("php://input"), $data);
        $id = intval($data['id']);

        $sql = "DELETE FROM CatBreeds WHERE id=$id";
        mysqli_query($conn, $sql);

        echo json_encode(["status" => "deleted"]);

        break;
}
?>
