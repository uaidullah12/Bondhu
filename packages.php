<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমাদের প্যাকেজসমূহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a2c5e;
            --secondary-color: #27ae60;
            --bg-color: #f0f2f5;
            --card-bg: white;
            --text-color: #333;
            --light-text: #777;
        }
        body { font-family: 'Arial', sans-serif; background: var(--bg-color); margin: 0; padding-bottom: 90px; color: var(--text-color); }
        .header { background: var(--primary-color); color: white; padding: 15px 20px; text-align: center; }
        .header h2 { margin: 0; font-size: 20px; }

        /* প্যাকেজ কার্ড ডিজাইন */
        .package-container { margin: 20px; display: grid; grid-template-columns: 1fr; gap: 20px; }
        .package-card { background: var(--card-bg); padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 6px solid var(--secondary-color); }
        .package-card h3 { color: var(--primary-color); margin-top: 0; font-size: 20px; }
        .package-card .price { font-size: 24px; font-weight: bold; color: var(--secondary-color); margin-bottom: 10px; }
        .package-card ul { list-style: none; padding: 0; margin: 15px 0; }
        .package-card ul li { margin-bottom: 8px; font-size: 15px; color: var(--text-color); }
        .package-card .buy-btn { background: var(--primary-color); color: white; padding: 12px 20px; border: none; border-radius: 10px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%; display: block; text-align: center; text-decoration: none; }
        .package-card .buy-btn:hover { background: #0e1e4a; }

        /* বটম নেভিগেশন */
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-bg); display: flex; justify-content: space-around; padding: 10px 0; border-top: 1px solid #eee; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); z-index: 1000; }
        .nav-item { text-align: center; text-decoration: none; color: var(--light-text); font-size: 12px; flex: 1; padding: 5px 0; }
        .nav-item i { font-size: 20px; display: block; margin-bottom: 3px; color: var(--primary-color); }
        .nav-item.active { color: var(--primary-color); font-weight: bold; }
        .nav-item.active i { color: var(--secondary-color); }
    </style>
</head>
<body>

<div class="header">
    <h2>আমাদের ইনভেস্টমেন্ট প্যাকেজ</h2>
</div>

<div class="package-container">
    <?php
    // উবাইদুল্লাহ ভাই, এখানে ডাটাবেজ থেকে কার্ডগুলো আনা হচ্ছে
    $query = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
    
    if(mysqli_num_rows($query) > 0) {
        while ($pkg = mysqli_fetch_assoc($query)) {
            ?>
            <div class="package-card">
                <h3><?php echo $pkg['name']; ?></h3>
                <div class="price">৳ <?php echo number_format($pkg['price'], 2); ?></div>
                <ul>
                    <li><i class="fas fa-sack-dollar"></i> দৈনিক ইনকাম: ৳ <?php echo $pkg['daily_profit']; ?></li>
                    <li><i class="fas fa-clock"></i> মেয়াদ: <?php echo $pkg['validity']; ?> দিন</li>
                    <li><i class="fas fa-calendar-alt"></i> মোট লাভ: ৳ <?php echo $pkg['daily_profit'] * $pkg['validity']; ?></li>
                </ul>
                <a href="process_invest.php?id=<?php echo $pkg['id']; ?>&amount=<?php echo $pkg['price']; ?>&package_name=<?php echo urlencode($pkg['name']); ?>" class="buy-btn">এখনই কিনুন</a>
            </div>
            <?php
        }
    } else {
        echo '<div style="text-align:center; padding:50px; color:#999;">বর্তমানে কোনো প্যাকেজ নেই। অ্যাডমিন থেকে যোগ করুন।</div>';
    }
    ?>
</div>

<div class="bottom-nav">
    <a href="index.php" class="nav-item"><i class="fas fa-home"></i><span>হোম</span></a>
    <a href="packages.php" class="nav-item active"><i class="fas fa-boxes"></i><span>প্যাকেজ</span></a>
    <a href="transactions.php" class="nav-item"><i class="fas fa-history"></i><span>হিস্টরি</span></a>
    <a href="profile.php" class="nav-item"><i class="fas fa-user-circle"></i><span>প্রোফাইল</span></a>
</div>

</body>
</html>
