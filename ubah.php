<?php
    session_start();
    if(!$_SESSION['login']){
        header("Location: login.php");
        exit;
    }

    require 'function.php';
    
    $id = $_GET["id"];
    $mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
    // var_dump($mhs["nim"]);


    if (isset($_POST["submit"])){
        if(change($_POST)>0){
            echo "
            <script> 
                alert ('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
?>


<!DOCTYPE html>
<head>
    <title>Edit Mahasiswa</title>
</head>

<body>
    <h1>Edit Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$mhs["id"]?>">
        <input type="hidden" name="gambarlama" value="<?=$mhs['gambar']?>">
        <ul>
            <li>
                <label for="nim">Nim :</label>
                <input type="text" name="nim" id="nim" required value="<?=$mhs["nim"]?>">
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?=$mhs["nama"]?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required value="<?=$mhs["email"]?>">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required value="<?=$mhs["jurusan"]?>">
            </li>
            <li>
                <label for="gambar">Gambar :</label> <br>
                <img src="img/<?=$mhs['gambar']?>"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah data!</button>
            </li>
        </ul>
    </form>
</body>