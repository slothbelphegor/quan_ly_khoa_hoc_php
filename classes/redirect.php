<?php
class Redirect{
    public static function to($location)
    {
        echo "<script>window.location.href = '$location.php'</script>";
    }
}