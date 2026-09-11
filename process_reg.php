<?php
ob_start();
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $refer = isset($_POST['refer']) ? mysqli_real_escape_string($conn, $_POST['refer']) : 'none';
    $user_id = rand(100000, 999999);

    if(!empty($mobile) && !empty($password)) {
        $sql = "INSERT INTO users (name, mobile, password, refer, user_id, balance) 
                VALUES ('$name', '$mobile', '$password', '$refer', '$user_id', '0.00')";

        if (mysqli_query($conn, $sql)) {
            // রেজিস্ট্রেশন সফল হলে সরাসরি সেশন সেট করে হোম পেজে পাঠিয়ে দেওয়া
            $_SESSION['user_id'] = $user_id; 
            echo "<script>alert('অভিনন্দন! আপনার একাউন্ট তৈরি হয়েছে।'); window.location='index.php';</script>";
        } else {
            echo "এরর: " . mysqli_error($conn);
        }
    } else {
        echo "সবগুলো ঘর পূরণ করুন!";
    }
}
ob_end_flush();
?>
