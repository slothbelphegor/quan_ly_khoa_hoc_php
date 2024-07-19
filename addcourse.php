<?
require 'inc/init.php';
Auth::requireLogin();

if (!Auth::isManager()) {
    Redirect::to('index');
}

$conn = require "inc/db.php";
$categories = Category::getCategory($conn);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $fullname = Uploadfile::process();
        if (!empty($fullname)) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $video = $_POST['video'];
            $duration = $_POST['duration'];
            $category_id = $_POST['category_id'];
            $course = new Course($name, $description, $price, $fullname, $video, $duration, $category_id);
            if ($course->addCourse($conn)) {

                Dialog::show("Course added successful");
                Redirect::to('index');
            } else {
                // phải gỡ image khỏi server
                unlink('uploads/$fullname');
                Dialog::show("Cannot add course");
            }
        }
    } catch (PDOException $e) {
        Dialog::show($e->getMessage());
        // có thể gọi trang xử lý lỗi ở đây
    }
}


?>


<? layouts(); ?>

<div class='content'>
    <!--Muốn đẩy file lên server thì cần có enctype="multipart/form-data-->
    <form class='validation-form' name="frmADDCOURSE" method="post" id='frmADDCOURSE' enctype="multipart/form-data">
        <fieldset>
            <h2>Add course</h2>
            <p class='row'>
                <label for="name">Title: </label>
                <span class='error'>*</span>
                <input name="name" id="name" type="text" placeholder="Name" />

            </p>
            <p class='row'>
                <label for="description">Description: </label>
                <input name="description" id="description" type="text" placeholder="Description" />
            </p>
            <p class='row'>
                <label for="price">Price: </label>
                <span class='error'>*</span>
                <input name="price" id="price" type="text" placeholder="Price" />

            </p>
            <p class='row'>
                <label for='category_id'>Category: </label>
                <span class='error'>*</span>
                <select name='category_id'>
                    <?php foreach ($categories as $category) : ?>
                        <option value=<? echo $category['id'] ?>><? echo $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p class='row'>
                <label for="video">Video: </label>
                <span class='error'>*</span>
                <input name="video" id="video" type="text" placeholder="Video" />

            </p>

            <p class='row'>
                <label for="duration">Duration: </label>
                <input name="duration" id="duration" type="text" placeholder="Duration" />

            </p>
            <div class='row'>
                <label for='file'>File hình ảnh</label>
                <input type='file' name='file' id='file' />
            </div>
            <p class='row'>
                <input class='btnSubmit' type="submit" value="Save" />
                <input class='btnReset' type="reset" value="Cancel" />
            </p>

        </fieldset>
    </form>
</div>

<? layouts('footer') ?>