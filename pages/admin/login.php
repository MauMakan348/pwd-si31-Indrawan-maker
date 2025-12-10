<?php 
session_start();
include '../../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    if(isset($_POST['login'])) {
        $input = $_POST['username'];
        $password = $_POST['password'];

        // cek input ke database apakah sudah sesuai atau belum dengan data yg ada

        if(filter_var($input, FILTER_VALIDATE_EMAIL)){
            $query = "SELECT * FROM users WHERE email ='${input}'";
        } else {
            $query = "SELECT * FROM users WHERE username ='${input}'";
        }

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if(password_verify($password, $row['password'])) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
                $_SESSION['username'] = $row['username'];

                header("Location: dashboard.php");
                exit();
            } 
            else {
            echo "<p style='color:red'>PASSWORD SALAH!!</p>";
        }
        
        } else {
            echo "<p style='color:red'>username atau email SALAH!!</p>";
        }

    }
    ?>
    <form method="post" action="">
        <label for="">username atau email</label> <br>
        <input type="text" name="username" placeholder="masukan username atau email" require> <br>

        <label for="">Password</label> <br>
        <input type="password" name="password"  placeholder="masukan password" require> <br>

        <button type="submit" name="login">Login</button>

    </form>
</body>
</html>
