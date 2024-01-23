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
if (session_id() === "") session_start();
