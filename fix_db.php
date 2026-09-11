<?php
include 'db.php';

// ১. আগের ইনভেস্টমেন্ট টেবিলটি ডিলেট করে দেওয়া (যাতে নতুন কলামসহ তৈরি হয়)
mysqli_query($conn, "DROP TABLE IF EXISTS investments");

// ২. ফ্রেশ ভাবে ইনভেস্টমেন্ট টেবিল তৈরি (সব কলাম সহ)
$sql = "CREATE TABLE investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    package_name VARCHAR(100),
    amount DECIMAL(10,2),
    daily_income DECIMAL(10,2),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_claim_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'active'
)";

if (mysqli_query($conn, $sql)) {
    echo "<h2 style='color:green;'>✅ অভিনন্দন উবাইদুল্লাহ ভাই!</h2>";
    echo "<p>আপনার ডাটাবেজ এখন পুরোপুরি ফ্রেশ এবং ঠিক করা হয়েছে। এখন আর কোনো এরর আসবে না।</p>";
} else {
    echo "<h2 style='color:red;'>❌ সমস্যা হয়েছে:</h2> " . mysqli_error($conn);
}

// ৩. অন্য টেবিলগুলোও চেক করে নেওয়া
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS packages (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), price DECIMAL(10,2), daily_profit DECIMAL(10,2), validity INT, validity_hours INT DEFAULT 0)");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS deposits (id INT AUTO_INCREMENT PRIMARY KEY, user_id VARCHAR(50), amount DECIMAL(10,2), method VARCHAR(50), transaction_id VARCHAR(100), status VARCHAR(20) DEFAULT 'pending')");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS withdraws (id INT AUTO_INCREMENT PRIMARY KEY, user_id VARCHAR(50), amount DECIMAL(10,2), method VARCHAR(20), number VARCHAR(20), status VARCHAR(20) DEFAULT 'pending')");

echo "<br><a href='index.php' style='padding:10px 20px; background:blue; color:white; text-decoration:none; border-radius:5px;'>হোম পেজে ফিরে যান</a>";
?>
