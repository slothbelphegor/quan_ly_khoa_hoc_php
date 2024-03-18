<!-- Day se la trang cua user register -->

<?php

require "inc/init.php";
layouts();

// Nhan nut submit r moi chay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    if ($password !== $repassword) {
        echo "Passwords do not match. Please try again.";
        exit; // Prevent further processing
    }

    if ($name != '' && $email != '' && $username != '' && $address != '' && $password != '' && $repassword != '') {
        $conn = require "inc/db.php";
        // Tao object user thuoc class User
        $user = new User($name, $email, $username, $address, $password);
        // $user->setName($name);
        // var_dump($user->name);
        echo "<pre>";
        print_r($user);
        echo "</pre>";
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

<h2>Register</h2>
<form class="validation-form" id="frmREGISTER" name="frmREGISTER" method="post">
    <fieldset>
        <p>
            <label for="name">Full name:</label>
            <input name="name" id="name" type="text" placeholder="Full name" autofocus>
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
            <input name="repassword" id="repassword" type="password" placeholder="Confirm Password" data-rule-equalTo="#password">
        </p>
        <p>
            <input class="btnSubmit" type="submit" value="Save">
            <input class="btnReset" type="reset" value="Cancel">
        </p>
        <p>
            <a class="forgot" href="login.php">Đã có tài khoản? Đăng nhập</a>
        </p>
    </fieldset>
</form>

<?
layouts("footer");
?>