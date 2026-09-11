<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Error: Login Required");
}

$u_id = $_SESSION['user_id'];
$amount = floatval($_GET['amount']);
$p_name = isset($_GET['package_name']) ? mysqli_real_escape_string($conn, $_GET['package_name']) : "Default Card";

// ১. ইউজারের ব্যালেন্স চেক (সঠিক কলাম নাম 'balance')
$res = mysqli_query($conn, "SELECT balance FROM users WHERE user_id='$u_id'");
$user = mysqli_fetch_assoc($res);

if ($user && $user['balance'] >= $amount) {
    // ২. ব্যালেন্স থেকে টাকা কাটা
    $update_bal = mysqli_query($conn, "UPDATE users SET balance = balance - $amount WHERE user_id='$u_id'");
    
    // ৩. কার্ড সেভ করা (investments টেবিলে)
    $insert_inv = mysqli_query($conn, "INSERT INTO investments (user_id, package_name, amount, status) VALUES ('$u_id', '$p_name', '$amount', 'active')");
    
    if ($update_bal && $insert_inv) {
        echo "<script>alert('অভিনন্দন! আপনার কার্ড কেনা সফল হয়েছে।'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('দুঃখিত! আপনার ব্যালেন্স পর্যাপ্ত নয়। বর্তমান ব্যালেন্স: ".$user['balance']."'); window.location='packages.php';</script>";
}
?>
