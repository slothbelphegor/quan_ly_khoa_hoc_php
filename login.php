<?php
require "inc/init.php";
layouts("header");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"];
    // $email = $_POST["email"];
    $password = $_POST["password"];

    if ($identifier != '' && $password != '') {
        $conn = require "inc/db.php";
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $rs = User::authenticatebyemail($conn, $identifier, $password);
        } else {
            $rs = User::authenticatebyphone($conn, $identifier, $password);
        }

        if ($rs) {
            echo "Đăng nhập thành công";
            Auth::login();
            $user_id = $_SESSION['user_id'];
            header("Location: index.php");
            exit;
        } else {
            Dialog::show("Thong tin dang nhap khong chinh xac");
        }
    }
}
?>

<form id="frmLOGIN" name="frmLOGIN" action="" method="post">
    <fieldset>
        <legend>Login Page</legend>
        <p>
            <label for="identifier">Email or Phone number:</label>
            <input name="identifier" id="identifier" type="text" placeholder="Email or Phone number" autofocus required>
        </p>
        <p>
            <label for="password">Password:</label>
            <input name="password" id="password" type="password" placeholder="Password" required>
        </p>
        <p>
            <input class="submitbtn" type="submit" value="Đăng nhập">
        </p>
        <p>
            <a class="forgot" href="forgot_password.php">Quên mật khẩu?</a>
        </p>
        <p>
            <a class="register" href="register.php">Chưa có tài khoản? Đăng ký</a>
        </p>
    </fieldset>
</form>

</html>

<?
layouts("footer");
?>