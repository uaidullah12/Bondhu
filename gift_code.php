<?php
ob_start(); // রিডাইরেক্ট সমস্যা সমাধানের জন্য
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['redeem'])) {
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    
    // ১. আপনার নতুন তৈরি করা 'bonus_codes' টেবিল থেকে কোড চেক করা হচ্ছে
    $res = mysqli_query($conn, "SELECT * FROM bonus_codes WHERE code='$code'");
    
    if ($res && mysqli_num_rows($res) > 0) {
        $gift = mysqli_fetch_assoc($res);
        $amount = $gift['amount'];
        $limit = $gift['usage_limit'];

        if ($limit > 0) {
            // ২. ব্যালেন্স বাড়ানো হচ্ছে
            $update_user = mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE user_id='$u_id'");
            
            // ৩. কোডের লিমিট ১ কমানো হচ্ছে
            $update_code = mysqli_query($conn, "UPDATE bonus_codes SET usage_limit = usage_limit - 1 WHERE code='$code'");
            
            if ($update_user && $update_code) {
                $msg = "<p style='color:green; font-weight:bold; background:#e8f5e9; padding:10px; border-radius:10px;'>অভিনন্দন! ৳$amount আপনার ব্যালেন্সে যোগ হয়েছে।</p>";
            } else {
                $msg = "<p style='color:red;'>ডাটাবেজে সমস্যা হয়েছে।</p>";
            }
        } else {
            $msg = "<p style='color:red; font-weight:bold; background:#ffebee; padding:10px; border-radius:10px;'>দুঃখিত! এই কোডটির লিমিট শেষ হয়ে গেছে।</p>";
        }
    } else {
        $msg = "<p style='color:red; font-weight:bold; background:#ffebee; padding:10px; border-radius:10px;'>ভুল কোড! সঠিক কোডটি আবার লিখুন।</p>";
    }
}
?>
