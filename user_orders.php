<!-- Tạm thời là vậy -->
<?php

require "inc/init.php";
$conn = require "inc/db.php";

// Auth::requireLogin();
if (!$conn) {
    die("Kết nối không thành công:");
}
Auth::requireLogin();
layouts();

$user_id = $_SESSION["user_id"];
$userOrders = Order::getUserOrders($conn, $user_id);

if ($userOrders !== null) {
?>
    <h1>Danh sách đơn hàng của người dùng</h1>
    <table>
        <thead>
            <tr>
                <th>ID đơn hàng</th>
                <th>Tên người dùng</th>
                <th>Tên khóa học</th>
                <th>Video</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userOrders as $order) : ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['user_name']; ?></td>
                    <td><?php echo $order['course_name']; ?></td>
                    <td> <a href='<?php echo $order['course_video']; ?>'>Link</a></td>            
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php
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
    <title>Quản lý khoá học</title>
</head>

<body>
    <!-- <form action="" method="post">
        <label for="user_id">Nhập ID người dùng:</label>
        <input type="number" id="user_id" name="user_id" required>
        <button type="submit">Tìm kiếm</button>
    </form> -->
</body>


</html>

<? layouts("footer"); ?>