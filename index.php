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
        
        if (Auth::isLoggedIn() && isset($_SESSION['user_id']) === true) {
            echo "Chào mừng bạn đến với trang web! <br>";
            echo "<button id='btnLogOut'>Đăng xuất</button><br>";
            echo "<a href='change_password.php'>Đổi mật khẩu</a><br>";
            echo "<a href='courses_management.php'>Các khoá học</a><br>";
            echo "<a href='user_orders.php'>Danh sách khoá học đã mua</a><br>";
            if($_SESSION['role_id'] == 1) {
                echo "<a href='user_management.php'>Quản lý người dùng</a>";
            }
        } else {
            echo "Xin chào, bạn chưa đăng nhập! <br>";
            echo "<a href='login.php'>Đăng nhập</a>";
        }

    }
    ?>
</body>

</html>

<? layouts("footer"); ?>