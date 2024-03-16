<?php

require 'inc/init.php';
$conn = require 'inc/db.php';

Auth::requireLogin();

if(!Auth::isAdmin()){
    Redirect::to('index');
}

if (isset($_GET['id'])) {
    $conn = require "inc/db.php";
    $id = $_GET['id'];
    $user = User::getUserInfo($conn, $id);
    if (!$user) {
        Redirect::to('user_management');
        return;
    }
} else {
    Dialog::show('Input ID, please');
    return;
}

Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (User::deactiveUser($conn, $id)) {
        Dialog::show('User đã tạm ngưng hoạt động');
        Redirect::to('user_management');
    } else {
        Dialog::show('Hiện khoá học không thành công');
    }
}