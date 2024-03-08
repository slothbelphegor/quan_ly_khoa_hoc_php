<?php

require 'inc/init.php';
$conn = require 'inc/db.php';

// Auth::requireLogin();


// $course = Course::getByID($conn, 1);
// echo "<pre>";
// print_r($course);
// echo "</pre>";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// Xử lý yêu cầu mua khóa học
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // echo $_POST["id"];
    $course_id = $_GET['id'];

    $user_id = $_SESSION['user_id'];

    $courses = Course::getByID($conn, $course_id);

    echo "<pre>";
    print_r($courses);
    echo "</pre>";

    $total_amount = $courses->price;

    $order = new Order($user_id, $course_id, $total_amount, "complete");
    if ($order->addOrder($conn)) {
        echo "<script>alert('Mua khoá học thành công')</script>";
        // header("Location: courses_management.php");
    } else {
        echo "Lỗi không thêm thành công";
    }
}
