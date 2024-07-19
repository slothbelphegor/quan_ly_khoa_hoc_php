<?php

require "inc/init.php";

Auth::requireLogin();
//Bắt buộc là admin mới vào được trang này. Nếu muốn thêm tài khoản admin thì comment lại
if (!Auth::isAdmin()) {
    Redirect::to('index');
}

$conn = require "inc/db.php";
$roles = Role::getRole($conn);

layouts();
// Nhan nut submit r moi chay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $is_active = $_POST["is_active"];
    $role_id = $_POST["role_id"];

    if ($name != '' && $email != '' && $username != '' && $address != '' && $password != '') {
        // Tao object user thuoc class User
        $user = new User($name, $email, $username, $address, $password, $is_active, $role_id);

        try {
            if ($user->addUser($conn)) {
                echo "Them thanh cong r yeeeeeeeeeee!";
            } else {
                echo "Xem lai di nao!";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>

<h2>Add New User</h2>
<form class="validation-form" id="frmADDUSER" name="afrmADDUSER" method="post">
    <fieldset>
        <p>
            <label for="name">Full name:</label>
            <input name="name" id="name" type="text" placeholder="Full name">
        </p>
        <p>
            <label for="email">Email:</label>
            <input name="email" id="email" type="email" placeholder="Email">
        </p>
        <p>
            <label for="username">Username:</label>
            <input name="username" id="username" type="text" placeholder="username">
        </p>
        <p>
            <label for="address">Address:</label>
            <input name="address" id="address" type="text" placeholder="Address">
        </p>
        <p>
            <label for="password">Password:</label>
            <input name="password" id="password" type="password" placeholder="Password">
        </p>
        <p>
            <label for="repassword">Confirm Password:</label>
            <input name="repassword" id="repassword" type="password" placeholder="Confirm Password">
        </p>
        <p>
            <label for="is_active">Is active?</label>
            <select name="is_active" id="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </p>

        <p>
            <label for="role_id">Role?</label>
            <select name="role_id" id="role_id">
                <?php foreach ($roles as $role) : ?>
                    <option value=<? echo $role['id'] ?>><? echo $role['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input class="btnSubmit" type="submit" value="Save">
            <input class="btnReset" type="reset" value="Cancel">
        </p>
    </fieldset>
</form>

<?php
layouts("footer");
?>