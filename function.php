<?php
    $connection = mysqli_connect("localhost", "root", "","phpdasar"); 

    function query($query){
        global $connection;
        $result = mysqli_query($connection, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    //cari tau fungsi query

    function add($data){
                // var_dump($_POST);
        global $connection;
        $nim = htmlspecialchars($data["nim"]);
        $nama = htmlspecialchars($data["nama"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        $email = htmlspecialchars($data["email"]);

        $gambar = upload();
        if(!$gambar){
            return false;
        }
        $query = "INSERT INTO mahasiswa 
                    VALUES
                    ('', '$nama','$nim', '$email', '$jurusan', '$gambar')
                    ";
        mysqli_query($connection, $query);
        return(mysqli_affected_rows($connection));
    }

    function change($data){
                // var_dump($_POST);
        global $connection;
        $id = $data["id"];
        $nim = htmlspecialchars($data["nim"]);
        $nama = htmlspecialchars($data["nama"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        $email = htmlspecialchars($data["email"]);
        $gambar = $data['gambarlama'];

        if($_FILES['gambar']['error'] !== 4){
            $gambar = upload();
        }
        $query = "UPDATE mahasiswa 
                    SET
                    nama = '$nama',
                    nim ='$nim', 
                    email = '$email', 
                    jurusan = '$jurusan', 
                    gambar = '$gambar'
                WHERE id = $id
                    ";
        mysqli_query($connection, $query);
        return(mysqli_affected_rows($connection));
    }


    function delete($data){
        global $connection;
        mysqli_query($connection, "DELETE FROM mahasiswa WHERE id = $data");
        return(mysqli_affected_rows($connection));
    }

    function search($data, $data2){
        $currentpage = $data2;
        $rowNumber = ($currentpage-1)*2;
        $tes = "SELECT * FROM mahasiswa WHERE
                    nama LIKE '$data%' OR
                    nim LIKE '$data%' OR
                    email LIKE '$data%' OR
                    jurusan LIKE '$data%'
        ";
        // don't forget question mark at SQL Query   
        // LIMIT $rowNumber, 2
        return query($tes);
    }

    function limitSearch($data, $data2){
        $currentpage = $data2;
        $rowNumber = ($currentpage-1)*2;
        $tes = "SELECT * FROM mahasiswa WHERE
                    nama LIKE '$data%' OR
                    nim LIKE '$data%' OR
                    email LIKE '$data%' OR
                    jurusan LIKE '$data%'
                    LIMIT $rowNumber, 2
        ";
        // don't forget question mark at SQL Query   

        return query($tes);
    }


    function upload(){
        $fileName = $_FILES['gambar']['name'];
        $fileSize = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        if($error === 4){
            echo " <script> 
            alert ('Masukan gambar terlebih dahulu');
            </script> 
            ";
            return false;
        }
        $validExtension = ['jpg', 'jpeg', 'png'];
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));
        if(!in_array($fileExtension, $validExtension)){
            echo " <script> 
            alert ('Format gambar salah');
            </script> 
            ";
            return false;
        }

        if($fileSize > 5000000){
            {
                echo " <script> 
                alert ('Ukuran gambar terlalu besar');
                </script> 
                ";
            }
            return false;
        }
        $fileName = uniqid().'.'.$fileExtension;
        move_uploaded_file($tmpName, 'img/' . $fileName);
        return $fileName;
    }

    function userRegister($data){
        global $connection;
        $username = strtolower(stripslashes($data['username']));
        $password = mysqli_real_escape_string($connection, $data['password']);
        $password2 = mysqli_real_escape_string($connection, $data['password2']);
        
        $result = mysqli_query($connection, "SELECT username FROM user WHERE username = '$username'");

        if(mysqli_fetch_assoc($result)){
            echo " <script>alert('User sudah terdaftar!'); </script>
            ";
            return false;
        }

        if($password !== $password2){
            echo " <script>alert('Password harus sama!'); </script>
            ";
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        // var_dump($password);
        mysqli_query($connection, "INSERT INTO user VALUES ('', '$username', '$password')");
        return mysqli_affected_rows($connection);
    }
    
?>