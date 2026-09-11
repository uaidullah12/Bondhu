<?php
include 'db.php';

// ১. প্যাকেজ টেবিল
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100), 
    price DECIMAL(10,2), 
    daily_profit DECIMAL(10,2), 
    validity INT,
    validity_hours INT DEFAULT 0
)");

// ২. বোনাস/গিফট কোড টেবিল
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS bonus_codes (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    code VARCHAR(50) UNIQUE, 
    amount DECIMAL(10,2),
    usage_limit INT DEFAULT 1
)");

// ৩. ডিপোজিট টেবিল
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS deposits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    amount DECIMAL(10,2),
    method VARCHAR(50),
    transaction_id VARCHAR(100),
    status VARCHAR(20) DEFAULT 'pending'
)");

// ৪. উইথড্র টেবিল
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS withdraws (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    amount DECIMAL(10,2),
    method VARCHAR(20),
    number VARCHAR(20),
    status VARCHAR(20) DEFAULT 'pending'
)");

// ৫. ইনভেস্টমেন্ট টেবিল (অসম্পূর্ণ অংশ পূর্ণ করা হয়েছে)
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    package_name VARCHAR(100),
    amount DECIMAL(10,2),
    daily_income DECIMAL(10,2),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'active'
)");

// --- অটো ফিক্স অংশ: last_claim_time কলাম যোগ করা ---
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM investments LIKE 'last_claim_time'");
if(mysqli_num_rows($check_column) == 0) {
    $fix_sql = "ALTER TABLE investments ADD COLUMN last_claim_time DATETIME DEFAULT CURRENT_TIMESTAMP";
    if (mysqli_query($conn, $fix_sql)) {
        echo "<p style='color:green;'>✅ last_claim_time কলাম সফলভাবে যোগ হয়েছে।</p>";
    } else {
        echo "<p style='color:red;'>❌ এরর: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:blue;'>ℹ️ last_claim_time কলামটি আগেই ডাটাবেজে আছে।</p>";
}

echo "<h3>🎉 ডাটাবেজ সেটআপ ও ফিক্স সম্পন্ন হয়েছে!</h3>";
?>
