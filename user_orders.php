<!-- Tạm thời là vậy -->
<?php

require "inc/init.php";
$conn = require "inc/db.php";

// Auth::requireLogin();
if (!$conn) {
    die("Kết nối không thành công:");
}

layouts();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $userOrders = Order::getUserOrders($conn, $user_id);

    if ($userOrders !== null) {
        // Hiển thị danh sách đơn hàng
        ?>
        <h1>Danh sách đơn hàng của người dùng</h1>
        <table>
            <thead>
                <tr>
                    <th>Tên người dùng</th>
                    <th>Tên khóa học</th>
                    <th>ID đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userOrders as $order) : ?>
                    <tr>
                        <td><?php echo $order['user_name']; ?></td>
                        <td><?php echo $order['course_name']; ?></td>
                        <td><?php echo $order['order_id']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    } else {
        // Xử lý lỗi nếu không tìm thấy đơn hàng
        echo "Lỗi: Không tìm thấy đơn hàng nào cho người dùng này.";
    }
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
    <form action="" method="post">
        <label for="user_id">Nhập ID người dùng:</label>
        <input type="number" id="user_id" name="user_id" required>
        <button type="submit">Tìm kiếm</button>
    </form>
</body>


</html>

<? layouts("footer"); ?>