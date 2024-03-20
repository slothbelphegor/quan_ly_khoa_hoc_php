<?
require "inc/init.php";
$conn = require "inc/db.php";

if (!$conn) {
    die("Kết nối không thành công:");
}

if (!isset($_SESSION['user_id'])) {
    Redirect::to('login.php');
}

$user_id = $_SESSION['user_id'];

$user = User::getUserInfo($conn, $user_id);
$nameError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    if (!preg_match("/^[A-Za-z]*$/", $name)) {
        $nameError = "Only characters are allowed";
    }

    if ($nameError === '') {
        if (User::updateUserInfo($conn, $user_id, $name, $email, $address)) {
            Dialog::show('Cập nhật thông tin thành công');
        } else {
            Dialog::show('Cập nhật thông tin không thành công');
        }
    }
    else {
       Dialog::show($nameError);
    }
}

?>
<? layouts(); ?>


<!-- Phần thông tin người dùng -->
<div class="user-info" id="user-info">
    <h2>Thông tin cá nhân</h2>
    <div class="info-item">
        <span class="label">Tên:</span>
        <span class="value"><?php echo $user['name']; ?></span>
    </div>
    <div class="info-item">
        <span class="label">Email:</span>
        <span class="value"><?php echo $user['email']; ?></span>
    </div>
    <div class="info-item">
        <span class="label">Địa chỉ:</span>
        <span class="value"><?php echo $user['address']; ?></span>
    </div>
    <button class="btnSubmit" id="btnEditProfile">Chỉnh sửa thông tin</button>
    <button class="btnSubmit" id="btnChangePassword">Đổi mật khẩu</button>
</div>


<div id="frmEDITPROFILE" style="display: none;">
    <h2>Chỉnh sửa thông tin cá nhân</h2>
    <form action="" method="POST">
        <label for="name">Họ và tên:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>

        <label for="address">Địa chỉ:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>"><br>

        <input type="submit" class="btnSubmit" value="Cập nhật">
        <button type="button" class="btnReset" id="btnCancelEdit">Hủy</button>
    </form>
</div>

<? layouts('footer'); ?>
<script>
    document.getElementById('btnEditProfile').addEventListener('click', function() {
        document.getElementById('frmEDITPROFILE').style.display = 'block';
        document.getElementById('user-info').style.display = 'none';
    });
    document.getElementById('btnCancelEdit').addEventListener('click', function() {
        document.getElementById('frmEDITPROFILE').style.display = 'none';
        document.getElementById('user-info').style.display = 'block';
    });
    document.getElementById('btnChangePassword').addEventListener('click', function() {
        window.location.href = "change_password.php";
    });
</script>

<style>
    .user-info {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .info-item {
        margin-bottom: 10px;
    }

    .label {
        font-weight: bold;
    }

    .value {
        margin-left: 10px;

    }
</style>