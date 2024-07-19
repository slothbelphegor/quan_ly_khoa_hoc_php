<?php

require 'inc/init.php';
$conn = require 'inc/db.php';

if (!isset($_SESSION['courses_management_access'])) {
    header("Location: index.php");
}

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

Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (Course::markAsNotDeleted($conn, $id)) {
        Dialog::show('Đã hiện khoá học');
        Redirect::to('courses_management');
    } else {
        Dialog::show('Hiện khoá học không thành công');
    }
}
