<?php
session_start();
if(!$_SESSION['login']){
    header("Location: login.php");
    exit;
}

    require 'function.php';
    if (isset($_POST["submit"])){
        if(add($_POST)>0){
            echo "
            <script> 
                alert ('data berhasil ditambahnkan');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
?>


<!DOCTYPE html>
<head>
    <title>Tambah Mahasiswa</title>
</head>

<body>
    <h1>Tambah Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nim">Nim :</label>
                <input type="text" name="nim" id="nim" required>
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah data!</button>
            </li>
        </ul>
    </form>
</body>