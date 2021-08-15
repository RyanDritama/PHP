<?php 
    session_start();
    if(!$_SESSION['login']){
        header("Location: login.php");
        exit;
    }

    //connect to database
    require 'function.php';
    $rowNumber = 2;
    if(isset($_GET['page'])){
        $currentPage = $_GET['page'];
    } else{
        $currentPage = 1;
    }

    if (!isset($_SESSION['search'])){
        $_SESSION['search'] = '';
    }

    if(!isset($pageNumber)){
        $pageNumber = 1;
    }

    if (isset($_POST["keyword"])) {
        $_SESSION['search'] = $_POST["keyword"];
        if($currentPage>$pageNumber && $pageNumber>0){
            $currentPage = 1;
            header('Location: index.php?page=1');
            exit;
        }
    }

    $mahasiswa = limitSearch($_SESSION['search'], $currentPage);
    $pageNumber = ceil(count(search($_SESSION['search'], $currentPage))/$rowNumber);

        //    echo $_SESSION['search']; echo '<br>';
        //    echo $currentPage; echo '<br>';
        //    echo $pageNumber; echo '<br>';






?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Admin</title>
    </head>
    <Body>
        <a href="logout.php">Log Out</a> <br>
        <h1>Daftar Mahasiswa</h1>
        <a href="tambah.php">Tambah Mahasiswa</a>
        <form action="" method="post">
            <input type="text" name="keyword" autofocus placeholder="Masukan keyword pencarian" autocomplete="off">
            <button type="submit" name="cari">Cari</button>
        </form>
        <br>
        <?php if ($currentPage > 1) :?>
            <a href="?page=<?=($currentPage-1)?>">&laquo</a>
        <?php endif; ?>

        <?php for ($i = 1; $i<=$pageNumber; $i++) : ?>
            <a href="?page=<?=$i?>"><?=$i?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $pageNumber) :?>
            <a href="?page=<?=($currentPage+1)?>">&raquo</a>
        <?php endif; ?>

        <?php $i = 1;?>
        <table border="1" cellpadding="10" cellspacing ="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        <?php foreach ($mahasiswa as $row) :?>
            <tr>
                <td><?php echo $i?></td>
                <td> <a href="ubah.php?id=<?=$row["id"]?>">ubah</a> | <a href="hapus.php?id=<?php echo $row["id"]?>">hapus</a></td>
                <td><img src="img/<?php echo $row["gambar"]?>" alt=""></td>
                <td><?php echo $row["nim"]?></td>
                <td><?php echo $row["nama"]?></td>
                <td><?php echo $row["email"]?></td>
                <td><?php echo $row["jurusan"]?></td>
                <?php $i++;?>
            </tr>
        <?php endforeach; ?>

    </table> 
    </Body>
</html>

