<?php
require "inc/init.php";
Auth::logout();
Redirect::to('login');
