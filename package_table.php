<?php
include 'db.php';
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price DECIMAL(10,2),
    daily_profit DECIMAL(10,2),
    validity INT
)");
echo "টেবিল তৈরি হয়েছে!";
?>
