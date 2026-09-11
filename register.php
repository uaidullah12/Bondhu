<?php
include 'db.php';

if (isset($_POST['reg_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $refer = mysqli_real_escape_string($conn, $_POST['refer']);
    $user_id = rand(100000, 999999);

    // ১. ডিভাইস আইডি সংগ্রহ (ইউজারের ব্রাউজার সিগনেচার)
    $device_id = $_SERVER['HTTP_USER_AGENT']; 

    // ২. ডিভাইস আইডি দিয়ে চেক করা (এক মোবাইলে আইডি আছে কি না)
    $check_device = mysqli_query($conn, "SELECT * FROM users WHERE device_id='$device_id'");

    // ৩. মোবাইল নম্বর দিয়ে চেক করা
    $check_number = mysqli_query($conn, "SELECT * FROM users WHERE number='$number'");

    if ($check_number && mysqli_num_rows($check_number) > 0) {
        echo "<script>alert('এই নম্বরটি দিয়ে ইতিমধ্যে অ্যাকাউন্ট খোলা হয়েছে!');</script>";
    } 
    // ৪. যদি একই ডিভাইস আইডি পাওয়া যায়, তবে বাধা দেওয়া
    else if (mysqli_num_rows($check_device) > 0) {
        echo "<script>alert('দুঃখিত! এই মোবাইল থেকে ইতিমধ্যে একটি অ্যাকাউন্ট খোলা হয়েছে। এক মোবাইলে একাধিক অ্যাকাউন্ট অনুমোদিত নয়।'); window.location='login.php';</script>";
    } 
    else {
        // ডাটাবেজে তথ্য জমা দেওয়া (device_id সহ)
        $sql = "INSERT INTO users (name, number, user_id, password, refer, balance, device_id) VALUES ('$name', '$number', '$user_id', '$password', '$refer', '0.00', '$device_id')";
        $insert = mysqli_query($conn, $sql);
        
        if ($insert) {
            echo "<script>alert('রেজিস্ট্রেশন সফল! আপনার ইউজার আইডি: $user_id'); window.location='login.php';</script>";
        } else {
            // যদি ডাটাবেজে device_id কলাম না থাকে তবে এরর দেখাবে
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>রেজিস্ট্রেশন - আল খিদমাহ</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 350px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid #1a2c5e; }
        h2 { text-align: center; color: #1a2c5e; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1.5px solid #eee; border-radius: 10px; box-sizing: border-box; font-size: 15px; outline: none; }
        input:focus { border-color: #1a2c5e; }
        button { width: 100%; background: #1a2c5e; color: white; padding: 13px; border: none; border-radius: 10px; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        button:hover { background: #15244d; }
        a { color: #1a2c5e; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2>নতুন অ্যাকাউন্ট</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="পুরো নাম" required>
            <input type="number" name="number" placeholder="মোবাইল নম্বর" required>
            <input type="password" name="password" placeholder="পাসওয়ার্ড" required>
            <input type="text" name="refer" placeholder="রেফার আইডি (থাকলে)">
            <button type="submit" name="reg_btn">সাইন আপ</button>
        </form>
        <p style="text-align:center; margin-top: 20px; font-size: 14px; color: #666;">
            ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="login.php">লগইন করুন</a>
        </p>
    </div>
</body>
</html>
