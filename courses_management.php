<!-- Sẽ còn chỉnh sửa nhiều, mục đích là để biết cách vào database-->
<?php
require "inc/init.php";
$conn = require "inc/db.php";


// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}
// Auth::requireLogin();

layouts();

$conn = require 'inc/db.php';
$total = $_SESSION['role_id'] == 1 ? Course::countAll($conn) : Course::count($conn);
$limit = 3;
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
    $courses = Course::searchCoursePaging($conn, $search,$limit,($currentpage - 1) * $limit);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <title>Danh sách khóa học</title>
</head>

<body>
<form action="" method="get">
        <input type="text" name="search" id="search" placeholder="Tìm kiếm khóa học">
        <button type="submit">Tìm kiếm</button>
    </form>
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
                        </td>
                    <?php endif; ?>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <div>
        <button id='logoutbtn'>Đăng xuất</button>
        <?php if (Auth::isLoggedIn() && $_SESSION['role_id'] == 1) : ?>
            <button id='addcoursebtn'>Thêm khoá học</button>
        <?php endif; ?>
    </div>

    <div class='content'>
    <?php
        $page = new Pagination($config);
        echo $page->getPagination();
    ?>
</div>

</body>

</html>

<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
Database::close($conn);
layouts("footer");
?>
