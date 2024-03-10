<?
require 'inc/init.php';
//Auth::requireLogin(); //bắt buộc phải đăng nhập

//xử lý file upload (đã đưa vào uploadfile.php)
/* function upload_file()
{
    try {
        if (empty($_FILES)) {
            //throw new Exception('Không thể upload tập tin'); //dùng lúc còn phát triển web (nhận biết lỗi)
            Dialog::show('Không thể upload tập tin'); //dùng sau khi phát triển xong (user friendly)
            return null;
        }

        // gọi hàm xử lý error trong class Errorfileupload
        $rs = Errorfileupload::err($_FILES['file']['error']);
        if ($rs != 'OK') {
            Dialog::show($rs);
            return null;
        }

        // giới hạn kích thước file < 2MB 
        $filemaxsize = FILE_MAX_SIZE;
        if ($_FILES['file']['size'] > $filemaxsize) {
            //throw new Exception('Kích thước tập tin phải <='); //dùng lúc còn phát triển web (nhận biết lỗi)
            Dialog::show('Kích thước tập tin phải <='); //dùng sau khi phát triển xong (user friendly)
            return null;
        }

        // giới hạn loại file hình ảnh
        $mime_types = FILE_TYPE;
        // kiểm tra phần thông tin file để đảm bảo rằng là file hình (notimg.doc.png vẫn là hình)
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        // file upload lưu trong tmp_name (tên của file hình do server đặt sau khi vào dc server)
        $file_mime_type = finfo_file($fileinfo, $_FILES['file']['tmp_name']);
        if (!in_array($file_mime_type, $mime_types)) {
            Dialog::show("Kiểu tập tin phải là hình ảnh");
            return null;
        }

        // Thực hiện upload file lên thư mục upload của server

        // chuẩn hóa tên file trước khi upload
        $pathinfo = pathinfo($_FILES['file']['name']);
        $filename = $pathinfo['filename'];
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);

        // xử lý không ghi đè nếu đã tồn tại file (2 người upload hình trùng tên)
        $fullname = $filename . '.' . $pathinfo['extension'];
        // tạo đường dẫn đến thư mục uploads
        $fileToHost = 'uploads/' . $fullname;
        $i = 1;
        // gán đuôi -1 -2 -3... cho tên file nếu trùng file
        while (file_exists($fileToHost)) {
            $fullname = $filename . '-$i.' . $pathinfo(['extension']);
            $fileToHost = 'uploads/' . $fullname;
            $i++;
        }
        $fileTmp = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($fileTmp, $fileToHost)) {
            return $fullname;
        } else {
            Dialog::show('Không thể upload tập tin!');
            return null;
        }
    } catch (Exception $e) {
        Dialog::show($e->getMessage());
        return null;
    }
} */
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
            $course = new Course($name,$description,$price,$fullname,$video,$duration,$category_id);
            if ($course->addCourse($conn)) {
                
                Dialog::show("Course added successful");
                header('Location: index.php');
            } else {
                // phải gỡ image khỏi form
                unlink('uploads/$fullname');
                Dialog::show("Cannot add book");
                
            }
        }
    } catch (PDOException $e) {
        Dialog::show($e->getMessage());
        // có thể gọi trang xử lý lỗi ở đây
    }
}


?>


<? 
//require 'inc/init.php';
require 'inc/header.php' ?>

<head>
    <link rel='stylesheet' href='css/style.css'/>
    <script src="js/script.js"></script>
    <title>Quan ly khoa hoc</title>
</head>

<div class='content'>
    <!--Muốn đẩy file lên server thì cần có enctype="multipart/form-data-->
    <form class='validation-form' name="frmADDCOURSE" method="post" id='frmADDCOURSE' enctype="multipart/form-data">
        <fieldset>
            <legend>Add Course</legend>
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
                        <option value=<?echo $category['id']?>><? echo $category['name'] ?></option>
                    <?php endforeach;?>
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
                <input class='btn' type="submit" value="Save" />
                <input class='btn' type="reset" value="Cancel"/>
            </p>

        </fieldset>
    </form>
</div>

<? require 'inc/footer.php' ?>