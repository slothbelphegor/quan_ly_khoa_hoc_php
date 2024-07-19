<?php

require 'inc/init.php';
$conn = require 'inc/db.php';
Auth::requireLogin();

if (!Auth::isManager()) {
    Redirect::to('index');
}
if (isset($_GET['id'])) {
    $conn = require "inc/db.php";
    $id = $_GET['id'];
    $order = Order::getByID($conn, $id);
    if (!$order) {
        Redirect::to('user_orders');
        return;
    }
} else {
    Dialog::show('Order ID not found');
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (Order::deleteByID($conn, $id)) {
        Dialog::show('Đã hủy đăng ký khóa học');
        Redirect::to('user_orders');
    } else {
        Dialog::show('Hủy đăng ký khoá học không thành công');
    }
}
