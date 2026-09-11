<?php
include 'db.php';
$u_id = '123456'; // ইউজারের আইডি (সেশন থেকে আসবে)

// লেভেল ১ মেম্বারদের খোঁজা (যারা সরাসরি এই ইউজারের রেফারে জয়েন করেছে)
$level1 = mysqli_query($conn, "SELECT * FROM users WHERE refer='$u_id'");
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার টিম - আল খিদমাহ</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding: 15px; }
        .team-box { background: white; border-radius: 15px; padding: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .level-header { background: #1a2c5e; color: white; padding: 10px; border-radius: 8px; margin-top: 15px; }
        .member-row { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .commission { color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>

<div class="team-box">
    <h3 style="text-align:center;">আমার টিম নেটওয়ার্ক</h3>
    
    <div class="level-header">লেভেল ১ (৮% বোনাস)</div>
    <?php if(mysqli_num_rows($level1) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($level1)): ?>
            <div class="member-row">
                <span>👤 <?php echo $row['name']; ?></span>
                <span class="commission">আইডি: <?php echo $row['user_id']; ?></span>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; color:#888;">কোনো মেম্বার নেই</p>
    <?php endif; ?>

    <p style="font-size: 12px; color: #666; text-align: center; margin-top: 20px;">
        টিম বড় করুন এবং ৩ লেভেল পর্যন্ত কমিশন উপভোগ করুন!
    </p>
</div>

</body>
</html>
