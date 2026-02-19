<?php
include "db_connect.php";
$sql = "SELECT * FROM CatBreeds";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการแมวยอดนิยม</title>

<style>
body{
    margin:0;
    font-family:"Segoe UI",Tahoma,sans-serif;
    background:linear-gradient(135deg,#fff1f5,#e0f7fa);
}
.cat-park{
    max-width:1200px;
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
    background:#ffffff;
    border-radius:30px;
    padding:30px;
    border:4px dashed #ffb6c1;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.btn{
    display:inline-block;
    background:linear-gradient(135deg,#ff9a9e,#fad0c4);
    color:#fff;
    padding:12px 24px;
    border-radius:30px;
    text-decoration:none;
    margin-right:10px;
    margin-bottom:25px;
}
.btn.secondary{
    background:linear-gradient(135deg,#a1c4fd,#c2e9fb);
}
.block-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:25px;
}
.cat-block{
    background:#fff7fa;
    border-radius:25px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
    text-align:center;
}
.cat-block img{
    width:160px;
    border-radius:20px;
    margin-bottom:10px;
}
.cat-name{
    font-size:20px;
    color:#ff6f91;
    font-weight:600;
    margin-bottom:6px;
}
.status{
    font-size:14px;
    margin-bottom:12px;
}
.actions button{
    margin:4px 3px;
    padding:6px 14px;
    border-radius:20px;
    border:none;
    font-size:14px;
    color:#fff;
    cursor:pointer;
}
.edit{ background:#ff9a9e; }
.delete{ background:#ff6f91; }
.toggle{ background:#a1c4fd; }
</style>
</head>

<body>

<div class="cat-park">

    <div class="header">
        <h2>จัดการข้อมูลแมวยอดนิยม</h2>
    </div>

    <div class="card">

        <a href="add_cat.php" class="btn">➕ เพิ่มแมว</a>
        <a href="show_cat.php" class="btn secondary" target="_blank">
            👀 ดูสำหรับผู้อ่าน
        </a>

        <div class="block-grid" id="catList"></div>

    </div>

</div>

<script>

// =======================
// โหลดข้อมูลจาก API
// =======================
function loadCats() {
    fetch("crud_catbreeds.php")
    .then(res => res.json())
    .then(data => {

        let output = "";

        data.forEach(cat => {

            output += `
            <div class="cat-block">

                <img src="Cat/${cat.image_url}">

                <div class="cat-name">${cat.name_th}</div>

                <div class="status">
                    สถานะ: ${cat.is_visible == 1 ? "แสดง" : "ไม่แสดง"}
                </div>

                <div class="actions">
                    <button class="edit"
                        onclick="editCat(${cat.id})">✏ แก้ไข</button>

                    <button class="delete"
                        onclick="deleteCat(${cat.id})">🗑 ลบ</button>

                    <button class="toggle"
                        onclick="toggleStatus(${cat.id}, ${cat.is_visible})">
                        ${cat.is_visible == 1 ? "ซ่อน" : "แสดง"}
                    </button>
                </div>

            </div>
            `;
        });

        document.getElementById("catList").innerHTML = output;
    });
}

// =======================
// แก้ไข
// =======================
function editCat(id){
    window.location.href = "add_cat.php?id=" + id;
}

// =======================
// ลบ
// =======================
function deleteCat(id){
    if(confirm("ลบข้อมูลนี้?")){
        fetch("crud_catbreeds.php",{
            method:"DELETE",
            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },
            body:"id="+id
        })
        .then(res=>res.json())
        .then(data=>{
            loadCats();
        });
    }
}

// =======================
// เปลี่ยนสถานะ
// =======================
function toggleStatus(id,currentStatus){

    let newStatus = currentStatus == 1 ? 0 : 1;

    let formData = new FormData();
    formData.append("id", id);
    formData.append("is_visible", newStatus);
    formData.append("name_th","");
    formData.append("name_en","");
    formData.append("description","");
    formData.append("characteristics","");
    formData.append("care_instructions","");
    formData.append("old_image","");

    fetch("crud_catbreeds.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.json())
    .then(data=>{
        loadCats();
    });
}

loadCats();

</script>

</body>
</html>
