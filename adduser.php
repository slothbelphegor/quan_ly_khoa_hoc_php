<?php

// require "config.php";
// require "classes/database.php";
// require "classes/user.php";

require "inc/init.php";

// Nhan nut submit r moi chay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];

    // echo $name ." ".$email." ".$phone." ".$address. " " .$password . "<br>";

    if ($name != '' && $email != '' && $phone != '' && $address != '' && $password != '') {
        $conn = require "inc/db.php";
        // Tao object user thuoc class User
        $user = new User($name, $email, $phone, $address, $password);
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

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Quan Ly Khoa Hoc</title>
</head>

<body>
    <h2>Add New User</h2>
    <form name="frmADDUSER" method="post">
        <fieldset>
            <legend>User Information</legend>
            <p>
                <label for="name">Full name:</label>
                <input name="name" id="name" type="text" placeholder="Full name">
            </p>
            <p>
                <label for="email">Email:</label>
                <input name="email" id="email" type="text" placeholder="Email">
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
                <input class="submitbtn" type="submit" value="Save">
                <input class="resetbtn" type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</body>

</html>