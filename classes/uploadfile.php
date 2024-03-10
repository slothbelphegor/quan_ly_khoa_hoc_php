<?
// để gọi hàm err của Errorfileupload
include "errorfileupload.php";

class Uploadfile
{
    public static function process()
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
            echo $fileToHost;
            // gán đuôi -1 -2 -3... cho tên file nếu trùng file
            while (file_exists($fileToHost)) {
                $fullname = $filename . "-" . $i . "." . $pathinfo['extension'];
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
    }
}
