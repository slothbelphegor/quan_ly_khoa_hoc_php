<?php

require "inc/init.php";
layouts();





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = require 'inc/db.php';
    // Kiểm tra xem người dùng đã nhập email hay chưa
    if (isset($_POST["email"])) {
        // Lấy email từ form
        $email = $_POST["email"];

        // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu hay không (giả sử bạn đã có hàm kiểm tra trong lớp User)
        if (User::emailExists($conn, $email)) {
            // Tạo mật khẩu mới ngẫu nhiên
            $newPassword = generateRandomPassword();
            Mail::sendMail('shinpham.mg5@gmail.com',$email,"New Password",$newPassword);
            
            
            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            User::updatePasswordByEmail($conn, $email, $newPassword);

        } else {
            Dialog::show('Email không tồn tại trong hệ thống');
        }
    }
}

// Hàm tạo mật khẩu ngẫu nhiên
function generateRandomPassword($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#?!@$%^&*-';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

?>



<form id="frmFORGOT" name="frmFORGOT" action="" method="post">
    <fieldset>
        <legend>Forgot password</legend>
        <p>
            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Email" autofocus required>
        </p>
        <p>
            <input class='btnSubmit' type="submit" value="Lấy lại mật khẩu" />
        </p>
    </fieldset>
</form>

<? layouts('footer') ?>