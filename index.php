<?php

require "inc/init.php";
$conn = require "inc/db.php";
if ($conn) {
    echo "Kết nối thành công database<br>";
    // $identifier = "test";
    // $password = "test";
    // if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
    //     $rs = User::authenticatebyemail($conn, $identifier, $password);
    // } else {
    //     $rs = User::authenticatebyphone($conn, $identifier, $password);
    // }

    if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id']) === true) {
        echo "Chào mừng bạn đến với trang web!";
    } else {
        echo "Xin chào, bạn chưa đăng nhập!";
    }

    // if ($rs) {
    //     echo "Đăng nhập thành công";
    // } else {
    //     echo "Sai tài khoản hoặc mật khẩu";
    // }
}
