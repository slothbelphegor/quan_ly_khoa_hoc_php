<?php
require "inc/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // echo $name ." ".$email." ".$phone." ".$address. " " .$password . "<br>";

    if ($email != '' && $password != '') {
        $conn = require "inc/db.php";
        $rs = User::authenticate($conn, $email, $password);
        if ($rs) {
            echo "Đăng nhập thành công";
        } else {
            echo "Sai tài khoản hoặc mật khẩu";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- <script src="js/script.js"></script> -->
    <title>Quan ly khoa hoc</title>
</head>

<body>
    <h2>Login Page</h2>
    <form name="frmLOGIN" action="" method="post">
        <fieldset>
            <legend>Login Page</legend>
            <p>
                <label for="email">Email:</label>
                <input name="email" id="email" type="email" placeholder="Email">
            </p>
            <p>
                <label for="password">Password:</label>
                <input name="password" id="password" type="password" placeholder="Password">
            </p>
            <p>
                <input type="submit" value="Đăng nhập">
            </p>
        </fieldset>
    </form>
</body>

</html>