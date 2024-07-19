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
    $course = Course::getByID($conn, $id);
    if (!$course) {
        Redirect::to('courses_management');
        return;
    }
} else {
    Dialog::show('Input ID, please');
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (Course::delCourse($conn, $id)) {
        Dialog::show('Đã xoá khoá học');
        Redirect::to('courses_management');
    } else {
        Dialog::show('Xoá khoá học không thành công');
    }
}
