<?php
    require 'function.php';
    session_start();

    if (isset($_COOKIE['id'])&& $_COOKIE['key']) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];
        $row = mysqli_fetch_assoc(mysqli_query($connection,"SELECT username FROM user WHERE id = $id")) ;
        if($key === hash('sha256', $row['username'])){
            $_SESSION['login'] = true;
        }
    }

    if(isset($_SESSION['login'])){
        header("Location: index.php");
        exit;
    }
    
    // require 'function.php';  jangan dideclare 2 kali
    if (isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username'");
        if(mysqli_num_rows($result) === 1){ // jangan error kurawal
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row['password'])){
                $_SESSION['login'] = true;
                if (isset($_POST['remember'])){
                    setcookie('id', $row['id'], time()+60 );
                    setcookie('key', hash('sha256', $row['username']), time()+60 );
                }
                header("Location: index.php");
                exit;
            }
        }
        $error = true;

    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Login</title>
        <style>
            label {
                display : block;
            }
        </style>
    </head>
    <body>
        <?php if (isset($error)) : ?>
            <p>Username/password salah</p>
        <?php endif; ?>
        <h1>Halaman Login</h1>
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
                    <label for="remember">Remember me</label>
                    <input type="checkbox" name="remember" id="remember">
                </li>
                <button type="submit" name="login">Login</button>
            </ul>
        </form>
    </body>
</html>