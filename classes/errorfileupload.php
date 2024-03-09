<?php
class Errorfileupload
{
    // Quản lý lỗi khi upload file
    /* Khi upload hình ảnh, lúc này nó chỉ mới nằm trên form
    chứ chưa vào server. File này xử lý cho bước upload này trước khi
    đưa lên server */
    public static function err($code)
    {
        switch ($code) {
            case UPLOAD_ERR_OK:
                $msg = 'OK';
                break;
            case UPLOAD_ERR_INI_SIZE:
                $msg = 'The uploaded file exceeds the upload_max_filesize';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $msg = 'The uploaded file exceeds the MAX_FILE_SIZE directive that is provided';
                break;
            case UPLOAD_ERR_PARTIAL:
                $msg = 'The uploaded file was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = 'Missing temporary folder';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $msg = 'Failed to write file to disk';
                break;
            case UPLOAD_ERR_EXTENSION:
                $msg = 'A PHP extension stopped the file upload';
                break;
            default:
                $msg = 'Unknown upload error';
                break;
        }
        return $msg;
    }
}
