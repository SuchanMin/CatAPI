<?php
include "db_connect.php";
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
    text-shadow:2px 2px #ffd1dc;
    margin:0;
}

.decor{
    font-size:42px;
    margin-bottom:10px;
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
    transition:0.2s;
}

.btn:hover{
    transform:scale(1.05);
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
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

.cat-title{
    font-size:26px;
    color:#ff6f91;
    margin:0 0 8px;
}

.sub-title{
    color:#777;
    margin-bottom:10px;
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
        <div class="decor">🎡 🐱 🎠</div>
        <h1>ข้อมูลแมวที่อัปโหลดแล้ว</h1>
    </div>

    <div class="card">

        <a href="admin_list.php" class="btn">⬅ กลับไปหน้า Admin</a>

        <!-- ✅ แสดงผลผ่าน API อย่างเดียว -->
        <div id="cat-container"></div>

<script>
async function fetchCats() {
    try {
        const response = await fetch('api_cats.php');
        const cats = await response.json();
        
        const container = document.getElementById('cat-container');
        container.innerHTML = '';

        cats.forEach(cat => {
            const catHtml = `
                <div class="cat-item">
                    <div class="cat-header">
                        <img src="Cat/${cat.image_url}" alt="รูปแมว">
                        <div>
                            <h3 class="cat-title">${cat.name_th}</h3>
                            <div class="sub-title">ชื่อภาษาอังกฤษ: ${cat.name_en}</div>
                        </div>
                    </div>
                    <div class="block-grid">
                        <div class="block full">
                            <div class="block-title">คำอธิบาย</div>
                            <div class="block-content">${cat.description}</div>
                        </div>
                        <div class="block">
                            <div class="block-title">ลักษณะนิสัย</div>
                            <div class="block-content">${cat.characteristics}</div>
                        </div>
                        <div class="block">
                            <div class="block-title">การเลี้ยงดู</div>
                            <div class="block-content">${cat.care_instructions}</div>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += catHtml;
        });
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

fetchCats();
</script>

    </div>
</div>

</body>
</html>
