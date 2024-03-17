<?php
require "inc/init.php";
layouts("header");

if (Auth::isLoggedIn()) {
    header('Location: index.php');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"];
    // $email = $_POST["email"];
    $password = $_POST["password"];

    if ($identifier != '' && $password != '') {
        $conn = require "inc/db.php";
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $rs = User::authenticatebyemail($conn, $identifier, $password);
        } else {
            $rs = User::authenticatebyusername($conn, $identifier, $password);
        }

        // if ($rs) {
        //     echo "Đăng nhập thành công";
        //     Auth::login();
        //     $user_id = $_SESSION['user_id'];
        //     header("Location: index.php");
        //     exit;
        // } else {
        //     Dialog::show("Thong tin dang nhap khong chinh xac");
        // }

        if ($rs) {
            if (User::isUserActive($conn, $identifier)) { // Kiểm tra trạng thái active của tài khoản
                echo "Đăng nhập thành công";
                Auth::login();
                $user_id = $_SESSION['user_id'];
                Redirect::to('index');
                exit;
            } else {
                Dialog::show("Tài khoản của bạn hiện không hoạt động. Vui lòng liên hệ quản trị viên.");
            }
        } else {
            Dialog::show("Thông tin đăng nhập không chính xác");
        }
    }
}
?>

<form id="frmLOGIN" name="frmLOGIN" action="" method="post">
    <fieldset>
        <p>
            <label for="identifier">Email or Username</label>
            <input name="identifier" id="identifier" type="text" placeholder="Email or Username" autofocus>
        </p>
        <p>
            <label for="password">Password:</label>
            <input name="password" id="password" type="password" placeholder="Password">
        </p>
        <p>
            <input class="btnSubmit" type="submit" value="Đăng nhập">
        </p>
        <p>
            <a class="hyperlink" href="forgot_password.php">Quên mật khẩu?</a>
        </p>
        <p>
            <a class="hyperlink" href="register.php">Chưa có tài khoản? Đăng ký</a>
        </p>
    </fieldset>
</form>


<?
layouts("footer");
?>