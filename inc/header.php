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

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css style2  -->
    <link rel="stylesheet" href="css/style2.css">
    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body>

    <section class="header">

        <a href="index.php" class="logo">
            <img src="images/logo.png"><span>COURSAIR</span>
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>

            <? if (Auth::isLoggedIn()) : ?>
                <a href="courses_management.php">Courses</a>
                <a href="myaccount.php">My Account</a>
                <? if ($_SESSION['role_id'] == 1) : ?>
                    <a href="user_management.php" class="text">Users</a>
                    <a href="adduser.php" class='text'>Add User</a>
                <? elseif ($_SESSION['role_id'] == 2) : ?>
                    <a href="user_orders.php" class="text">Orders</a>
                <? endif; ?>
                <a href="logout.php" class="text" onclick="return confirmLogout();">Logout</a>

            <? else : ?>
                <a href=" login.php">Login</a>
            <? endif; ?>

            <!-- <a>Liên hệ</a> -->

        </nav>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/script2.js"></script>
        <script>
            function confirmLogout() {
                // Sử dụng hàm confirm của JavaScript để hiển thị hộp thoại xác nhận
                if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                    return true; // Trả về true để chuyển hướng đến trang logout.php
                } else {
                    return false; // Trả về false để không chuyển hướng
                }
            }
        </script>
        <marquee direction="right"><img src="images/felix.gif" width="125"></marquee>