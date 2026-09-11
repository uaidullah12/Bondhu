<?php
error_reporting(0);
include 'db.php';
$u_id = '123456'; // আপনার টেস্ট আইডি

// ইউজারের কেনা প্যাকেজগুলো ডাটাবেজ থেকে আনা
// নোট: আপনার ডাটাবেজে 'user_packages' নামে একটি টেবিল থাকতে হবে যেখানে কেনা প্ল্যান জমা হয়
$my_plans = mysqli_query($conn, "SELECT * FROM user_packages WHERE user_id='$u_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার ইনভেস্টমেন্ট - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding-bottom: 80px; }
        .header { background: #1a2c5e; color: white; padding: 20px; text-align: center; border-radius: 0 0 20px 20px; }
        .plan-card { background: white; margin: 15px; padding: 15px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid #27ae60; }
        .plan-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; }
        .status { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .detail-row { display: flex; justify-content: space-between; margin: 5px 0; font-size: 13px; color: #555; }
        .no-plan { text-align: center; margin-top: 50px; color: #999; }
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: white; display: flex; justify-content: space-around; padding: 12px 0; border-top: 1px solid #ddd; }
        .nav-item { text-align: center; text-decoration: none; color: #666; font-size: 12px; }
        .nav-item i { display: block; font-size: 20px; color: #1a2c5e; margin-bottom: 3px; }
    </style>
</head>
<body>

<div class="header">
    <h3 style="margin:0;">আমার ইনভেস্টমেন্ট প্ল্যান</h3>
</div>

<?php if(mysqli_num_rows($my_plans) > 0): ?>
    <?php while($plan = mysqli_fetch_assoc($my_plans)): ?>
    <div class="plan-card">
        <div class="plan-header">
            <h4 style="margin:0; color:#1a2c5e;"><?php echo $plan['package_name']; ?></h4>
            <span class="status">রানিং</span>
        </div>
        <div class="detail-row">
            <span>ক্রয়মূল্য:</span>
            <span style="font-weight:bold;">৳ <?php echo $plan['price']; ?></span>
        </div>
        <div class="detail-row">
            <span>প্রতিদিন ইনকাম:</span>
            <span style="color:#27ae60;">৳ <?php echo $plan['daily_profit']; ?></span>
        </div>
        <div class="detail-row">
            <span>মোট ইনকাম হবে:</span>
            <span>৳ <?php echo ($plan['daily_profit'] * $plan['validity']); ?></span>
        </div>
        <div class="detail-row">
            <span>বাকি মেয়াদ:</span>
            <span style="color:#e67e22;"><?php echo $plan['remaining_days']; ?> দিন</span>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="no-plan">
        <i class="fas fa-box-open" style="font-size: 50px; margin-bottom: 10px;"></i>
        <p>আপনার কোনো সক্রিয় ইনভেস্টমেন্ট নেই।</p>
        <a href="index.php" style="color:#1a2c5e; font-weight:bold;">এখনই কিনুন</a>
    </div>
<?php endif; ?>

<div class="bottom-nav">
    <a href="index.php" class="nav-item"><i class="fas fa-home"></i>হোম</a>
    <a href="invest.php" class="nav-item" style="color:#1a2c5e;"><i class="fas fa-layer-group"></i>মাই প্ল্যান</a>
    <a href="team.php" class="nav-item"><i class="fas fa-users"></i>টিম</a>
    <a href="logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i>লগআউট</a>
</div>

</body>
</html>
