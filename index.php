<?php

require "inc/init.php";
layouts("header");
$conn = require "inc/db.php";

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_index.css">
    <script src="js/script.js"></script>
    <title>Quản lý khoá học</title>


</head>

<body>
    <? if ($conn) : ?>




        <div class="hero_section">
            <div class="hero_content">
                <div class="hero_main_text">
                    Uy tín, chất lượng!
                </div>
                <div class="hero_sub_text">
                    Với những khóa học từ các chuyên gia hàng đầu
                </div>

            </div>

            <img src='images/meetings.jfif' class="hero_image" alt="Computer Image" width="600" height="'400">
        </div>

        <div class="ad_section">
            <div class="ad_text">
                <div class="ad_title">
                    Số lượng có hạn!
                </div>
                <div class="ad_subtext">
                    Hãy nhanh chóng đăng ký mua khóa học ngay hôm nay!
                </div>
            </div>
            <button class="btn ad_btn" >Đăng ký</button>
        </div>

        <!-- <div class="quote_section">
            <blockquote class="quote_content">
                "Học tập là một việc phải tiếp tục suốt đời"
            </blockquote>
            <p class="quote_author">Hồ Chí Minh</p>
        </div> -->



    <? endif; ?>

</body>

</html>

<? layouts("footer"); ?>