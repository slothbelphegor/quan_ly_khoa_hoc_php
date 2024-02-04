<!-- Sẽ còn chỉnh sửa nhiều, mục đích là để biết cách vào database-->
<?php
require "inc/init.php";
$conn = require "inc/db.php";


// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}
Auth::requireLogin();

layouts();

// Lấy tất cả khóa học
$courses = Course::getAll($conn);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) { ?>
                <tr>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['description']; ?></td>
                    <td><?php echo $course['price']; ?></td>
                    <td><?php echo $course['image']; ?></td>
                    <td><?php echo $course['video']; ?></td>
                    <td><?php echo $course['duration']; ?></td>
                    <td><?php echo $course['category_id']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    "<button id='logoutbtn'>Đăng xuất</button>";
</body>

</html>

<?php
Database::close($conn);
layouts("footer");
?>