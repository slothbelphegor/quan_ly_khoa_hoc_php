<?php

require 'inc/init.php';
$conn = require 'inc/db.php';

if (isset($_GET['id'])) {
    $conn = require "inc/db.php";
    $id = $_GET['id'];
    $course = Course::getByID($conn, $id);
    if (!$course) {
        header("Location: courses_management.php");
        return;
    }
} else {
    Dialog::show('Input ID, please');
    return;
}

// Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (Course::markAsDeleted($conn, $id)) {
        Dialog::show('Đã ẩn khoá học');
        echo "<script>window.location.href = 'courses_management.php'</script>";
    } else {
        Dialog::show('Ẩn khoá học không thành công');
    }
}