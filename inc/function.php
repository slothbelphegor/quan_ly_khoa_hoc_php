<?php
function layouts($layoutName = "header"){
    if(file_exists(WEB_PATH.'/inc/'.$layoutName.'.php')){
        require WEB_PATH.'/inc/'.$layoutName.'.php';
    }
}