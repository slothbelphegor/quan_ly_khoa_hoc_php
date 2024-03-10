<?php
require "inc/init.php";
Auth::logout();
header("Location:login.php");
