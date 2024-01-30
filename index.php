<?php

require "inc/init.php";
layouts();
$conn = require "inc/db.php";

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>

    <title>Quản lý khoá học</title>
</head>

<body>
    <?
    if ($conn) {
        echo "Kết nối thành công database<br>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        // $identifier = "test";
        // $password = "test";
        // if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        //     $rs = User::authenticatebyemail($conn, $identifier, $password);
        // } else {
        //     $rs = User::authenticatebyphone($conn, $identifier, $password);
        // }

        if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id']) === true) {
            echo "Chào mừng bạn đến với trang web! <br>";
            echo "<button id='logoutbtn'>Đăng xuất</button>";
        } else {
            echo "Xin chào, bạn chưa đăng nhập! <br>";
            echo "<a href='login.php'>Đăng nhập</a>";
        }

        // if ($rs) {
        //     echo "Đăng nhập thành công";
        // } else {
        //     echo "Sai tài khoản hoặc mật khẩu";
        // }


    }
    ?>
</body>

</html>

<? layouts("footer"); ?>