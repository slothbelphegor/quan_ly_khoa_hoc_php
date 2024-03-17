<?php

require 'inc/init.php';
$conn = require 'inc/db.php';
Auth::requireLogin();

// Xử lý yêu cầu mua khóa học
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     // echo "<pre>";
//     // print_r($_POST);
//     // echo "</pre>";
//     // echo $_POST["id"];
//     $course_id = $_GET['id'];

//     $user_id = $_SESSION['user_id'];

//     $course = Course::getByID($conn, $course_id);

//     $total_amount = $course->price;

//     $order = new Order($user_id, $course_id, $total_amount, "complete");
//     if ($order->addOrder($conn)) {
//         Dialog::show('Mua khoá học thành công');
//         Redirect::to('courses_management');
//     } else {
//         Dialog::show('Lỗi! không mua thành công');
//         Redirect::to('courses_management');
//     }
// }


// Xử lý yêu cầu mua khóa học
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Kiểm tra xem đã gửi id của khóa học hay chưa
    if (isset($_GET['id'])) {
        $course_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];

        $order = new Order();
        if ($order->userHasBoughtCourse($conn, $user_id, $course_id)) {
            Dialog::show('Bạn đã sở hữu khóa học này.');
            Redirect::to('courses_management');
        }

        $course = Course::getByID($conn, $course_id);

        // Kiểm tra xem khóa học có tồn tại hay không
        if ($course) {
            $total_amount = $course->price;

            $order = new Order($user_id, $course_id, $total_amount, "complete");
            if ($order->addOrder($conn)) {
                Dialog::show('Mua khoá học thành công');
                Redirect::to('courses_management');
            } else {
                Dialog::show('Lỗi! Không mua thành công');
                Redirect::to('courses_management');
            }
        } else {
            Dialog::show('Khóa học không tồn tại');
            Redirect::to('courses_management');
        }
    } else {
        Dialog::show('Không có thông tin về khóa học');
        Redirect::to('courses_management');
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng về trang quản lý khóa học
    Redirect::to('courses_management');
}
