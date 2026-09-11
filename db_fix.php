<?php
include 'db.php';

// ১. 'user_id' কলাম যোগ করার কমান্ড
$sql1 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS user_id VARCHAR(50) AFTER id";

// ২. 'balance' কলাম যোগ করার কমান্ড
$sql2 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS balance DECIMAL(10,2) DEFAULT 0.00";

if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo "<h1 style='color:green; text-align:center;'>সফলভাবে ডাটাবেজ আপডেট হয়েছে!</h1>";
    echo "<p style='text-align:center;'>এখন রেজিস্ট্রেশন করুন, আর এরর আসবে না।</p>";
} else {
    echo "<h1 style='color:red;'>ভুল:</h1> " . mysqli_error($conn);
}
?>
