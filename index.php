<?php

require "inc/init.php";
layouts("header");
$conn = require "inc/db.php";

?>
<link rel="stylesheet" href="css/style_index.css">

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

        <img src='images/meetings.jpg' class="hero_image" alt="Computer Image" width="600" height="'400">
    </div>
    <? if (!Auth::isLoggedIn()) : ?>
        <div class="ad_section">
            <div class="ad_text">
                <div class="ad_title">
                    Số lượng có hạn!
                </div>
                <div class="ad_subtext">
                    Hãy nhanh chóng đăng ký mua khóa học ngay hôm nay!
                </div>
            </div>
            <button class="btn ad_btn">Đăng ký</button>
        </div>
    <? endif;  ?>
    <!-- <div class="quote_section">
            <blockquote class="quote_content">
                "Học tập là một việc phải tiếp tục suốt đời"
            </blockquote>
            <p class="quote_author">Hồ Chí Minh</p>
        </div> -->
<? endif; ?>

<? layouts("footer"); ?>