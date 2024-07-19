<?php

require "inc/init.php";
$conn = require "inc/db.php";

Auth::requireLogin();
if (!$conn) {
    die("Kết nối không thành công:");
}
Auth::requireLogin();
layouts();
$user_id = $_SESSION["user_id"];
$total = Order::countUserOrder($conn, $user_id);
$limit = PAGE_SIZE;
$currentpage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
$config = [
    'total' => $total,
    'limit' => $limit,
    'full' => false,
];

//$userOrders = Order::getUserOrders($conn, $user_id);
$userOrders = Order::getPaging($conn, $limit, ($currentpage - 1) * $limit, $user_id);

if ($userOrders !== null) {
?>
    <h1>Danh sách đơn hàng của bạn</h1>
    <table>
        <thead>
            <tr>
                <th>ID đơn hàng</th>
                <th>Tên người dùng</th>
                <th>Tên khóa học</th>
                <th>Video</th>
                <th>Hủy đăng ký</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userOrders as $order) : ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['user_name']; ?></td>
                    <td><?php echo $order['course_name']; ?></td>
                    <td> <a href='<?php echo $order['course_video']; ?>'>Link</a></td>
                    <td>
                        <button value="<?php echo $order['order_id'] ?>" 
                        name="id" 
                        class="btnDeleteOrder btnCRUD">
                            Hủy đăng ký
                        </button>  
                    </td> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='content'>
        <?php
        $page = new Pagination($config);
        echo $page->getPagination1();
        ?>

    <?php
}

    ?>

    <? layouts("footer"); ?>