<?php
include "db_connect.php";
$result=$conn->query("SELECT * FROM CatBreeds WHERE is_visible=1");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Cat Amusement Park</title>

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
.header h1{
    font-size:38px;
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
.btn{
    display:inline-block;
    background:linear-gradient(135deg,#a1c4fd,#c2e9fb);
    color:#fff;
    padding:10px 22px;
    border-radius:30px;
    text-decoration:none;
    margin-bottom:30px;
}
.cat-item{
    background:#fff7fa;
    border-radius:25px;
    padding:25px;
    margin-bottom:35px;
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}
.cat-header{
    display:flex;
    gap:25px;
    align-items:flex-start;
    margin-bottom:20px;
}
.cat-header img{
    width:260px;
    border-radius:25px;
}
.cat-title{
    font-size:26px;
    color:#ff6f91;
}
.block-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}
.block{
    background:#ffffff;
    border-radius:20px;
    padding:18px;
    border:2px dashed #ffd1dc;
}
.block.full{
    grid-column:1 / -1;
}
.block-title{
    font-weight:600;
    color:#ff6f91;
    margin-bottom:6px;
}
.block-content{
    color:#555;
    line-height:1.6;
}
</style>
</head>

<body>

<div class="cat-park">

    <div class="header">
        <h1>ข้อมูลแมวที่อัปโหลดแล้ว</h1>
    </div>

    <div class="card">

        <a href="admin_list.php" class="btn">⬅ กลับไปหน้า Admin</a>

        <div id="catList"></div>

    </div>

</div>

<script>

fetch("crud_catbreeds.php")
.then(res => res.json())
.then(data => {

    let output = "";

    data.forEach(cat => {

        if(cat.is_visible == 1){   // แสดงเฉพาะที่ visible

            output += `
            <div class="cat-item">

                <div class="cat-header">
                    <img src="Cat/${cat.image_url}"
                         onerror="this.src='images/cat_default.jpg';">

                    <div>
                        <h3 class="cat-title">${cat.name_th}</h3>
                        <div>ชื่อภาษาอังกฤษ: ${cat.name_en}</div>
                    </div>
                </div>

                <div class="block-grid">

                    <div class="block full">
                        <div class="block-title">คำอธิบาย</div>
                        <div class="block-content">
                            ${cat.description}
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-title">ลักษณะนิสัย</div>
                        <div class="block-content">
                            ${cat.characteristics}
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-title">การเลี้ยงดู</div>
                        <div class="block-content">
                            ${cat.care_instructions}
                        </div>
                    </div>

                    <div class="block full">
                        <div class="block-title">สถานะการแสดง</div>
                        <div class="block-content">
                            ${cat.is_visible == 1 ? "แสดง" : "ไม่แสดง"}
                        </div>
                    </div>

                </div>

            </div>
            `;
        }
    });

    document.getElementById("catList").innerHTML = output;
});

</script>

</body>
</html>
