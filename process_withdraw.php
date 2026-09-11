<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = '123456'; // আপাতত ফিক্সড আইডি
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $number = $_POST['number'];

    // ব্যালেন্স চেক
    $user_check = mysqli_query($conn, "SELECT balance FROM users WHERE user_id='$u_id'");
    $user = mysqli_fetch_assoc($user_check);

    if ($user['balance'] >= $amount && $amount >= 500) {
        // রিকোয়েস্ট জমা করা
        $sql = "INSERT INTO withdrawals (user_id, amount, method, number, status) VALUES ('$u_id', '$amount', '$method', '$number', 'pending')";
        
        if (mysqli_query($conn, $sql)) {
            // ইউজারের ব্যালেন্স থেকে টাকা কেটে নেওয়া
            mysqli_query($conn, "UPDATE users SET balance = balance - $amount WHERE user_id='$u_id'");
            echo "<script>alert('রিকোয়েস্ট সফল হয়েছে!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('অপর্যাপ্ত ব্যালেন্স অথবা ভুল পরিমাণ!'); window.location='withdraw.php';</script>";
    }
}
?>