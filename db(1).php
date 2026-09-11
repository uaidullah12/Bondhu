<?php
// ডাটাবেজ কানেকশন
$conn = mysqli_connect("127.0.0.1", "root", "", "my_earning_app");

if (!$conn) {
    die("কানেকশন ফেল: " . mysqli_connect_error());
}
?>
