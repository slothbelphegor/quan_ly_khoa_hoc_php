<?
require "inc/init.php";
$conn = require "inc/db.php";
Auth::requireLogin();

$roles = Role::getRole($conn);

if (!Auth::isAdmin()) {
    Redirect::to('index');
}

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}

Auth::requireLogin();
// $total = Auth::isAdmin() ? User::countAll($conn) : User::countUsers($conn);
$total = User::countAll($conn);
$limit = PAGE_SIZE;
$currentpage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
$config = [
    'total' => $total,
    'limit' => $limit,
    'full' => false,
];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $role = isset($_GET['role']) ? $_GET['role'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($search === '' && $role === '') {
        $users = User::getPaging($conn, $limit, ($currentpage - 1) * $limit);
    } elseif ($search !== '' && $role === '') {
        $users = User::searchUser($conn, $search, $limit, ($currentpage - 1) * $limit);
    }else{
        $users = User::searchByRole($conn, $search, $role, $limit, ($currentpage - 1) * $limit);
    }
}

?>
<? layouts(); ?>


<form action="" method="get" class="search-container">
    <input value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" type="text" name="search" id="search" placeholder="<?= isset($_GET['search']) ? $_GET['search'] : 'Tìm kiếm người dùng'; ?>">
    <select name="role" id="role">
        <option value="" <?= !isset($_GET['role']) ? 'selected' : ''; ?>>Tất cả vai trò</option>
        <?php foreach ($roles as $role) : ?>
            <option value="<?= $role['id'] ?>" <?= isset($_GET['role']) && $_GET['role'] == $role['id'] ? 'selected' : ''; ?>><?= $role['name'] ?></option>
        <?php endforeach; ?>
    </select>
    </select>


    <button type="submit" class='btnSubmit'>Lọc</button>
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
                    <td><?php echo Role::getRoleName($conn, $user['role_id']); ?></td>

                    <td>
                        <?php if ($user['is_active'] == false) : ?>
                            <button value="<?php echo $user['id']; ?>" name="id" id="btnActive" class="btnCRUD">Mở khoá</button>
                        <?php else : ?>
                            <button value="<?php echo $user['id']; ?>" name="id" id="btnDeactive" class="btnCRUD">Tạm khoá</button>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <? if (!isset($_GET['search'])) : ?>
            <tfoot>
                <tr>
                    <th colspan=4 style="text-align:center;">Tổng số người dùng: </td>
                    <td colspan=3 style=><? echo $config['total'] ?></td>
                </tr>

            </tfoot>
        <? endif; ?>

    </table>
    </table>
<?php else : ?>
    <p>Không tìm thấy kết quả phù hợp</p>
<?php endif; ?>
<div class='content'>
    <?php
    $page = new Pagination($config);
    echo $page->getPagination1();
    ?>
</div>
<button class="btnSubmit" id="btnAddUser">Thêm người dùng</button>
<? layouts('footer'); ?>
<style>
    .search-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-container select {
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>