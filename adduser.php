<!-- Day se la trang cua admin, them tai khoan -->
<?php

require "inc/init.php";
layouts();
// Nhan nut submit r moi chay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $is_active = $_POST["is_active"];
    $role_id = $_POST["role_id"];

    // if (!is_numeric($is_active)) {
    //     echo "Giá trị `is_active` không hợp lệ!";
    //     exit;
    // }

    // if (!is_numeric($role_id)) {
    //     echo "Giá trị `role_id` không hợp lệ!";
    //     exit;
    // }

    if ($name != '' && $email != '' && $phone != '' && $address != '' && $password != '') {
        $conn = require "inc/db.php";
        // Tao object user thuoc class User
        $user = new User($name, $email, $phone, $address, $password, $is_active, $role_id);

        echo "<pre>";
        print_r($user);
        echo "</pre>";
        // $user->test($conn);
        try {
            // echo $user->getName();
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

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <title>Quan Ly Khoa Hoc</title>
</head>

<body>
    <h2>Add New User</h2>
    <form class="validation-form" id="frmADDUSER" name="afrmADDUSER" method="post">
        <fieldset>
            <legend>User Information</legend>
            <p>
                <label for="name">Full name:</label>
                <input name="name" id="name" type="text" placeholder="Full name">
            </p>
            <p>
                <label for="email">Email:</label>
                <input name="email" id="email" type="email" placeholder="Email">
            </p>
            <p>
                <label for="phone">Phone:</label>
                <input name="phone" id="phone" type="text" placeholder="Phone">
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
                    <option value="1">Administrator</option>
                    <option value="2">User</option>
                </select>
            </p>
            <p>
                <input class="submitbtn" type="submit" value="Save">
                <input class="resetbtn" type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</body>

</html>
<?php
layouts("footer");
?>