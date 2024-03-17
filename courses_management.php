<?
require "inc/init.php";
$conn = require "inc/db.php";

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}

Auth::requireLogin();

layouts();

$conn = require 'inc/db.php';
$total = $_SESSION['role_id'] == 1 ? Course::countAll($conn) : Course::count($conn);
$limit = PAGE_SIZE;
$currentpage = $_GET['page'] ?? 1;
$config = [
    'total' => $total,
    'limit' => $limit,
    'full' => false,

];
// $courses = $_SESSION['role_id'] == 1 ? 
//             Course::getPagingAll($conn, $limit, ($currentpage - 1) * $limit) :
//             Course::getPaging($conn, $limit, ($currentpage - 1) * $limit);
// Lấy tất cả khóa học
//$courses = Course::getAllCustom($conn);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $courses = Course::searchCoursePaging($conn, $search, $limit, ($currentpage - 1) * $limit);
    // $courses = Course::searchCourse($conn, $search);
} else {
    $courses = $_SESSION['role_id'] == 1 ?
        Course::getPagingAll($conn, $limit, ($currentpage - 1) * $limit) :
        Course::getPaging($conn, $limit, ($currentpage - 1) * $limit);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
</head>

<body>
    <form action="" method="get">
        <input type="text" name="search" id="search" placeholder="Tìm kiếm khóa học">
        <button type="submit">Tìm kiếm</button>
    </form>
    <?php if (!empty($courses)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Thời lượng</th>
                    <th>Loại khóa học</th>
                    <?php if (Auth::isLoggedIn() && $_SESSION['role_id'] == 2) : ?>
                        <th>Mua khóa học</th>
                    <?php elseif (Auth::isLoggedIn() && $_SESSION['role_id'] == 1) : ?>
                        <th>Chức năng</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td><?php echo $course['name']; ?></td>
                        <td><?php echo $course['description']; ?></td>
                        <td><?php echo $course['price']; ?></td>
                        <td>
                            <? if ($course['image'] && file_exists("uploads/" . $course['image'])) : ?>
                                <img src="uploads/<? echo $course['image'] ?>" width="80" height="80">
                            <? else : ?>
                                <img src="images/noimage.png" width="80" height="80">
                            <? endif; ?>
                        </td>
                        <td><?php echo $course['duration']; ?></td>
                        <td><?php echo $course['category_name']; ?></td>
                        <?php if (Auth::isLoggedIn() && $_SESSION['role_id'] == 2) : ?>
                            <td>
                                <button value="<? echo $course['id'] ?>" name="id" id="btnBuyCourse">Mua khoá học</button>
                            </td>
                        <?php elseif (Auth::isLoggedIn() && $_SESSION['role_id'] == 1) : ?>
                            <td>
                                <button value="<? echo $course['id'] ?>" name="id" id="btnChangeCourse">Sửa khoá học</button>
                                <button value="<? echo $course['id'] ?>" name="id" id="btnDeleteCourse">Xoá khoá học</button>
                                <button value="<? echo $course['id'] ?>" name="id" id="btnEditImage">Sửa hình</button>
                                <?php if ($course['deleted'] == false) : ?>
                                    <button value="<?php echo $course['id']; ?>" name="id" id="btnHideCourse">Ẩn khóa học</button>
                                <?php else : ?>
                                    <button value="<?php echo $course['id']; ?>" name="id" id="btnShowCourse">Hiện khóa học</button>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Không tìm thấy kết quả phù hợp</p>
    <?php endif; ?>
    <div class='content'>
        <?php
        $page = new Pagination($config);
        echo $page->getPagination();
        ?>
    </div>

    <?php if (Auth::isLoggedIn() && $_SESSION['role_id'] == 1) : ?>
        <a href="addcourse.php">Thêm khoá học</a>
    <?php endif; ?>

</body>
<a href="index.php">Quay lại trang chủ</a>
</html>

<?php
Database::close($conn);
layouts("footer");
?>