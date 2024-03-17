<?
require "inc/init.php";
$conn = require "inc/db.php";
Auth::requireLogin();

if (!Auth::isAdmin()) {
    Dialog::show('Bạn không có quyền truy cập trang web này');
    Redirect::to('index');
}

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}

Auth::requireLogin();
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $users = User::seachUser($conn, $search);
}else{
    $users = User::getAllUserInfo($conn);
}

// echo '<pre>';
// print_r($users);
// echo '</pre>';

?>
<? layouts(); ?>
<form action="" method="get">
    <input type="text" name="search" id="search" placeholder="Tìm kiếm khóa học">
    <button type="submit" id="btnSearch">Tìm kiếm</button>
</form>
<h1>Danh sách người dùng</h1>
<?php if (!empty($users)) : ?>
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Username</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Vai trò</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['address']; ?></td>
                    <td><?php echo $user['is_active'] == 1 ? 'Active' : 'Inactive'; ?></td>
                    <td><?php echo $user['role_id'] == 1 ? 'Admin' : 'User'; ?></td>
                    <td>
                        <?php if ($user['is_active'] == false) : ?>
                            <button value="<?php echo $user['id']; ?>" name="id" id="btnActive">Mở khoá</button>
                        <?php else : ?>
                            <button value="<?php echo $user['id']; ?>" name="id" id="btnDeactive">Tạm khoá</button>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Không tìm thấy kết quả phù hợp</p>
<?php endif; ?>
<? layouts('footer');
