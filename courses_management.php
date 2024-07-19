<?
require "inc/init.php";
$conn = require "inc/db.php";

$_SESSION['courses_management_access'] = true;

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công:");
}

$categories = Category::getCategory($conn);
if(Auth::isAdmin()){
    Redirect::to('index');
}
Auth::requireLogin();

layouts();

$total = Auth::isManager() ? Course::countAll($conn) : Course::count($conn);
$limit = PAGE_SIZE;
$currentpage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
$config = [
    'total' => $total,
    'limit' => $limit,
    'full' => false,

];



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $category_id = isset($_GET['category']) ? $_GET['category'] : '';

    if ($search === '' && $category_id === '') {
        $courses = Auth::isManager() ?
            Course::popularCoursesAll($conn, $limit, ($currentpage - 1) * $limit) :
            Course::popularCourses($conn, $limit, ($currentpage - 1) * $limit);
    } elseif ($search !== '' && $category_id === '') {
        $courses = Course::searchPopularPaging($conn, $search, $limit, ($currentpage - 1) * $limit);
    } else {
        $courses = Course::searchByCategoryAndTerm($conn, $search, $category_id, $limit, ($currentpage - 1) * $limit);
    }
}

isset($_GET['search']) ? $_GET['search'] : "Tìm kiếm khoá học";

?>

<form action="" method="get" class="search-container">
    <input value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" type="text" name="search" id="search" placeholder="<?php echo isset($_GET['search']) ? $_GET['search'] : 'Tìm kiếm khóa học'; ?>">
    <select name="category" id="category">
        <option value="" <?php echo !isset($_GET['category']) ? 'selected' : ''; ?>>Tất cả danh mục</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['id'] ?>" <?php echo isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : ''; ?>><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class='btnSubmit'>Tìm kiếm</button>
</form>


<?php
if (Auth::isManager()) {
    require 'courses_admin.php';
} else {
    require 'courses_user.php';
}
?>


<div class='content'>
    <?php
    $page = new Pagination($config);
    echo $page->getPagination1();
    ?>
</div>
<?php if (Auth::isManager()) : ?>
    <button class="btnSubmit" id="btnAddCourse">Thêm khóa học</button>
<? endif; ?>

<?php
Database::close($conn);
layouts("footer");
?>
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