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

<form action="" method="get">
    <input type="text" name="search" id="search" placeholder="Tìm kiếm khóa học">
    <button type="submit" class='btnSubmit'>Tìm kiếm</button>
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
                    <td class='shortcell'><?php echo $course['duration']; ?></td>
                    <td class='shortcell'><?php echo $course['category_name']; ?></td>
                    <?php if (Auth::isLoggedIn() && $_SESSION['role_id'] == 2) : ?>
                        <td class='shortcell'>
                            <button value="<? echo $course['id'] ?>" name="id" id="btnBuyCourse" class='btnCRUD'>Mua khoá học</button>
                        </td>
                    <?php elseif (Auth::isLoggedIn() && $_SESSION['role_id'] == 1) : ?>
                        <td class='shortcell'>
                            <button value="<? echo $course['id'] ?>" name="id" id="btnChangeCourse" class='btnCRUD'>Sửa khoá học</button>
                            <button value="<? echo $course['id'] ?>" name="id" id="btnDeleteCourse" class='btnCRUD'>Xoá khoá học</button>
                            <button value="<? echo $course['id'] ?>" name="id" id="btnEditImage" class='btnCRUD'>Sửa hình</button>
                            <?php if ($course['deleted'] == false) : ?>
                                <button value="<?php echo $course['id']; ?>" name="id" id="btnHideCourse" class='btnCRUD'>Ẩn khóa học</button>
                            <?php else : ?>
                                <button value="<?php echo $course['id']; ?>" name="id" id="btnShowCourse" class='btnCRUD'>Hiện khóa học</button>
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


<?php
Database::close($conn);
layouts("footer");
?>