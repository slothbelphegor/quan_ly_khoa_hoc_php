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

// Lấy tất cả khóa học
$courses = Course::getAllCustom($conn);

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
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Video</th>
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
                    <td><?php echo $course['image']; ?></td>
                    <td><?php echo $course['video']; ?></td>
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
                        </td>
                    <?php endif; ?>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <button id='logoutbtn'>Đăng xuất</button>
</body>

</html>

<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
Database::close($conn);
layouts("footer");
?>