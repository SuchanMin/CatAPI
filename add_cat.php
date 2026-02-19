<?php
include "db_connect.php";

$data = [
    'id'=>'','name_th'=>'','name_en'=>'',
    'description'=>'','characteristics'=>'',
    'care_instructions'=>'','image_url'=>'',
    'is_visible'=>1
];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM CatBreeds WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เพิ่ม / แก้ไขแมว</title>

<style>
body{
    margin:0;
    font-family:"Segoe UI",Tahoma,sans-serif;
    background:linear-gradient(135deg,#fff1f5,#e0f7fa);
}
.cat-park{
    max-width:900px;
    margin:40px auto;
    padding:20px;
}
.header{
    text-align:center;
    margin-bottom:30px;
}
.header h2{
    font-size:34px;
    color:#ff6f91;
    margin:0;
}
.card{
    background:#fff;
    border-radius:30px;
    padding:30px;
    border:4px dashed #ffb6c1;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
label{
    font-weight:600;
    color:#555;
}
input, textarea, select{
    width:100%;
    padding:12px;
    border-radius:20px;
    border:2px solid #ffd1dc;
    margin-top:6px;
    margin-bottom:16px;
    font-size:14px;
}
button{
    background:linear-gradient(135deg,#ff9a9e,#fad0c4);
    border:none;
    padding:14px 30px;
    border-radius:30px;
    color:#fff;
    font-size:16px;
    cursor:pointer;
}
.preview img{
    width:160px;
    border-radius:20px;
}
</style>
</head>

<body>

<div class="cat-park">
    <div class="header">
        <h2>เพิ่ม / แก้ไขข้อมูลแมว</h2>
    </div>

    <div class="card">

        <form id="catForm">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="old_image" id="old_image">

            <label>ชื่อไทย</label>
            <input name="name_th" id="name_th">

            <label>ชื่ออังกฤษ</label>
            <input name="name_en" id="name_en">

            <label>คำอธิบาย</label>
            <textarea name="description" id="description"></textarea>

            <label>ลักษณะนิสัย</label>
            <textarea name="characteristics" id="characteristics"></textarea>

            <label>การเลี้ยงดู</label>
            <textarea name="care_instructions" id="care_instructions"></textarea>

            <label>รูปภาพ</label>
            <input type="file" name="image" id="image">

            <div class="preview" id="preview"></div>

            <label>สถานะการแสดง</label>
            <select name="is_visible" id="is_visible">
                <option value="1">แสดง</option>
                <option value="0">ไม่แสดง</option>
            </select>

            <div style="text-align:center;">
                <button type="submit">🐾 บันทึกข้อมูล</button>
            </div>
        </form>

    </div>
</div>

<script>

// ========================
// โหลดข้อมูลเมื่อมี id
// ========================
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");

if (id) {
    fetch("crud_catbreeds.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById("id").value = data.id;
        document.getElementById("name_th").value = data.name_th;
        document.getElementById("name_en").value = data.name_en;
        document.getElementById("description").value = data.description;
        document.getElementById("characteristics").value = data.characteristics;
        document.getElementById("care_instructions").value = data.care_instructions;
        document.getElementById("is_visible").value = data.is_visible;
        document.getElementById("old_image").value = data.image_url;

        if (data.image_url) {
            document.getElementById("preview").innerHTML =
                `<img src="Cat/${data.image_url}">`;
        }
    });
}

// ========================
// บันทึกข้อมูลผ่าน API
// ========================
document.getElementById("catForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("crud_catbreeds.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert("บันทึกสำเร็จ");
        window.location.href = "admin_list.php";
    });
});

</script>

</body>
</html>
