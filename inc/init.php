<?php
// Tu dong goi cac class tuong ung
spl_autoload_register(
    function ($className) {
        // Ten lop tuong ung voi ten file chua lop nhung ghi in chu dau
        $fileName = strtolower($className) . ".php";
        $dirRoot = dirname(__DIR__);
        require $dirRoot . "/classes/{$fileName}";
    }
);
require dirname(__DIR__) . "/config.php";
require dirname(__DIR__) . "/inc/function.php";
if (session_id() === "") session_start();

function errorHandler($level, $message, $file, $line)
{
    throw new ErrorException($message, 0, $level, $file, $line);
}

function exceptionHandler($ex)
{
    if (DEBUG) {
        echo "<h2>Lỗi</h2>";
        echo "<p>Exception: " . get_class($ex) . "</p>";
        echo "<p>Nội dung: " . $ex->getMessage() . "</p>";
        echo "<p>Tập Tin: " . $ex->getFile() . " dòng thứ: " . $ex->getLine() . "</p>";
    } else {
        echo "<h2>Lỗi, Vui lòng thử lại</h2>";
    }
}
// Khi xảy ra lỗi thì dùng hàm của tôi
set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');
