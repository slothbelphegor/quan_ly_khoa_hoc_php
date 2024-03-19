<?php
require "inc/init.php";
layouts("header");
$passwordError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $newPassword)) {
        $passwordError = "Mật khẩu phải chứa ít nhất 8 ký tự và bao gồm chữ hoa, chữ thường, chữ số và ký tự đặc biệt";
    }

    if (!empty($email) && !empty($password) && !empty($newPassword) && !empty($confirmPassword)) {
        if ($passwordError !== '') {
            Dialog::show($passwordError);
        }

        if ($newPassword !== $confirmPassword) {
            Dialog::show('Mật khẩu mới và mật khẩu xác nhận không khớp');
        } else {
            $conn = require "inc/db.php";

            if (User::authenticatebyemail($conn, $email, $password)) {
                if (User::updatePassword($conn, $email, $newPassword)) {
                    Dialog::show('Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
                    Redirect::to('logout');
                } else {
                    Dialog::show("Đã xảy ra lỗi khi đổi mật khẩu");
                }
            } else {
                    Dialog::show("Email không chính xác");
                    
            }
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin";
    }
}
?>

<form id="frmChangePassword" name="frmChangePassword" action="" method="post">
    <fieldset>
        <h2>Đổi mật khẩu</h2>
        <p>
            <label for="email">Email:</label>
            <input name="email" id="email" type="email" placeholder="Email" required>
        </p>
        <p>
            <label for="password">Mật khẩu cũ:</label>
            <input name="password" id="password" type="password" placeholder="Mật khẩu cũ" required>
        </p>
        <p>
            <label for="new_password">Mật khẩu mới:</label>
            <input name="new_password" id="new_password" type="password" placeholder="Mật khẩu mới" required>
        </p>
        <p>
            <label for="confirm_password">Nhập lại mật khẩu mới:</label>
            <input name="confirm_password" id="confirm_password" type="password" placeholder="Nhập lại mật khẩu mới" required>
        </p>
        <p>
            <input class="btnSubmit" type="submit" value="Đổi mật khẩu">
        </p>
    </fieldset>
</form>

<?php
layouts("footer");
?>