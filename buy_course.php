<?php

require 'inc/init.php';
$conn = require 'inc/db.php';
Auth::requireLogin();

// Xử lý yêu cầu mua khóa học
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // echo $_POST["id"];
    $course_id = $_GET['id'];

    $user_id = $_SESSION['user_id'];

    $course = Course::getByID($conn, $course_id);

    $total_amount = $course->price;

    $order = new Order($user_id, $course_id, $total_amount, "complete");
    if ($order->addOrder($conn)) {
        Dialog::show('Mua khoá học thành công');
        Redirect::to('courses_management');
    } else {
        Dialog::show('Lỗi! không mua thành công');
        Redirect::to('courses_management');
    }
}
