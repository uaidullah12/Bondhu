<?php
ob_start();
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE mobile='$mobile' AND password='$password'");
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // এখানে user_id সেশনে সেট করা হচ্ছে
        $_SESSION['user_id'] = $user['user_id']; 
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('ভুল নম্বর বা পাসওয়ার্ড!'); window.location='login.php';</script>";
    }
}
ob_end_flush();
?>
