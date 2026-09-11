<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];

    // রিকোয়েস্টের তথ্য আনা
    $res = mysqli_query($conn, "SELECT * FROM deposits WHERE id='$id'");
    $data = mysqli_fetch_assoc($res);
    $u_id = $data['user_id'];
    $amount = $data['amount'];

    if ($action == 'approve') {
        // ১. ইউজারের ব্যালেন্স বাড়িয়ে দেওয়া
        mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE user_id='$u_id'");
        // ২. স্ট্যাটাস কমপ্লিট করা
        mysqli_query($conn, "UPDATE deposits SET status='completed' WHERE id='$id'");
        
        echo "<script>alert('টাকা সফলভাবে যোগ করা হয়েছে!'); window.location='manage_deposits.php';</script>";
    } else {
        // রিজেক্ট করলে শুধু ডিলিট বা রিজেক্ট স্ট্যাটাস
        mysqli_query($conn, "UPDATE deposits SET status='rejected' WHERE id='$id'");
        echo "<script>alert('রিকোয়েস্ট বাতিল করা হয়েছে!'); window.location='manage_deposits.php';</script>";
    }
}
?>
