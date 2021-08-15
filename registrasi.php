<?php
    require 'function.php';
    if (isset($_POST['register'])){
        // var_dump($_POST['username']); die;
        if(userRegister($_POST) > 0){
            echo " <script>alert('user berhasil ditambahkan'); </script>
            ";
        } else {
            echo mysqli_error($connection);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Registrasi</title>
        <style>
            label {
                display : block;
            }
        </style>
    </head>
    <body>
        <h1>Halaman Registrasi</h1>
        <br>

        <form action="" method="POST">
            <ul>
                <li>
                    <label for="usernama">Username</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <label for="password2">Konfirmasi password</label>
                    <input type="password" name="password2" id="password2">
                </li>
                <button type="submit" name="register">Register!</button>
            </ul>
        </form>
    </body>
</html>