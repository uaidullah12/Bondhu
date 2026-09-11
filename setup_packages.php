<?php
include 'db.php';

// প্যাকেজ বা কার্ড রাখার টেবিল তৈরি
$sql = "CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    daily_profit DECIMAL(10,2) NOT NULL,
    validity INT NOT NULL
)";

if(mysqli_query($conn, $sql)){
    echo "<h1>অভিনন্দন!</h1>";
    echo "<p>প্যাকেজ টেবিল সফলভাবে তৈরি হয়েছে। এখন আপনি অ্যাডমিন প্যানেল থেকে কার্ড যোগ করতে পারবেন।</p>";
    echo "<a href='admin.php'>অ্যাডমিন প্যানেলে ফিরে যান</a>";
} else {
    echo "ভুল হয়েছে: " . mysqli_error($conn);
}
?>
