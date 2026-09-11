<?php
// ডাটাবেজ কানেকশন
// 127.0.0.1 এর বদলে localhost ব্যবহার করে দেখুন
$conn = mysqli_connect("localhost", "root", "", "my_earning_app");

if (!$conn) {
    // এখানে এররটি স্পষ্টভাবে দেখার জন্য error_reporting চালু রাখতে পারেন
    die("কানেকশন ফেল: " . mysqli_connect_error());
}
?>
