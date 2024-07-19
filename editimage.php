<?
require 'inc/init.php';
Auth::requireLogin();

if (!Auth::isManager()) {
    Redirect::to('index');
}
// kiểm tra xem thật sự có id đó không (người dùng có thể can thiệp id)
if (isset($_GET['id'])) {
    $conn = require 'inc/db.php';
    // đọc id truyền từ trang index (querystring)
    $id = $_GET['id'];
    $course = course::getByID($conn, $id);
    if (!$course) {
        Dialog::show('Course not found');
        return;
    }
} else {
    Dialog::show("Input ID please");
    return;
}

/* 
    Upload hình mới lên thư mục uploads
    Cập nhật lại tên hình mới trong DB
    Xóa hình cũ trong thư mục uploads
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $fullname = Uploadfile::process();
        if (!empty($fullname)) {
            // lấy tên file hình cũ
            $oldimage = $course->image;
            // gán tên file hình mới
            $course->image = $fullname;
            $course->id = $_GET['id'];

            if ($course->updateImage($conn)) {
                if ($oldimage) {
                    // gỡ hình cũ khỏi server (vậy nên mới cần lấy tên hình cũ)
                    unlink("uploads/$oldimage");
                }
                Redirect::to('index');
            }
        }
    } catch (PDOException $e) {
        //throw new Exception($e->getMessage());
        Dialog::show($e->getMessage());
    }
}
?>

<? layouts('header'); ?>

<div class='content'>
    <form method='post' enctype="multipart/form-data" id='frmEDITIMAGE'>
        <fieldset>
            <legend>Edit Image</legend>
            <!-- Hiện hình ảnh nếu có-->
            <? if ($course->image) : ?>
                <img src='uploads/<?= $course->image ?>' width="180" height='180' />
            <? else : ?>
                <img src="images/noimage.png" width="80" height="80">
            <? endif; ?>
            <div class='row'>
                <label for='file'>Chọn hình ảnh</label>
                <input type='file' name='file' id='file' />
            </div>
            <div class="row">
                <input class='btnSubmit' type='submit' value="Update" />
                <input class='btnReset' type='button' value="Cancel" onClick='parent.location="courses_management.php"' />

            </div>
        </fieldset>
    </form>
</div>

<? layouts('footer'); ?>