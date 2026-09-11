<?php
include 'db.php';

// যাদের বিনিয়োগ একটিভ আছে তাদের লিস্ট
$investments = mysqli_query($conn, "SELECT * FROM investments WHERE status='active' AND days_left > 0");

while($row = mysqli_fetch_assoc($investments)){
    $u_id = $row['user_id'];
    $profit = $row['daily_profit'];
    $inv_id = $row['id'];

    // ইউজারের ব্যালেন্সে টাকা যোগ করা
    mysqli_query($conn, "UPDATE users SET balance = balance + $profit WHERE user_id = '$u_id'");
    
    // মেয়াদ ১ দিন কমানো
    mysqli_query($conn, "UPDATE investments SET days_left = days_left - 1 WHERE id = '$inv_id'");
    
    // মেয়াদ শেষ হলে ইনভেস্টিং বন্ধ করা
    mysqli_query($conn, "UPDATE investments SET status='expired' WHERE id = '$inv_id' AND days_left <= 0");
}

echo "আজকের ইনকাম সফলভাবে সবার একাউন্টে যোগ হয়েছে!";
?>
