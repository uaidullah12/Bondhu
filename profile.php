<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];
$user_res = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$u_id'");
$user = mysqli_fetch_assoc($user_res);

// ইউজারের টোটাল ডিপোজিট হিসাব করা
$total_dep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM deposits WHERE user_id='$u_id' AND status='success'"));
$dep_amount = $total_dep['total'] ?? 0;

// ইউজারের টোটাল উইথড্র হিসাব করা
$total_wit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM withdraws WHERE user_id='$u_id' AND status='success'"));
$wit_amount = $total_wit['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f7f6; margin: 0; padding-bottom: 100px; }
        
        /* প্রিয় ব্লু হেডার */
        .header-bg { 
            background: #1a2c5e; 
            height: 150px; 
            border-radius: 0 0 30px 30px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            color: white;
            margin-bottom: 20px;
        }
        .profile-img { font-size: 60px; margin-bottom: 5px; }

        /* টাকা প্রদর্শন বক্স (নতুন সেকশন) */
        .status-container {
            display: flex; 
            gap: 15px; 
            padding: 0 20px;
            margin-top: -30px;
            margin-bottom: 20px;
        }
        .status-box {
            flex: 1; 
            background: white; 
            padding: 15px; 
            border-radius: 20px; 
            text-align: center; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            border: 1px solid #eee;
        }

        /* মেনু গ্রিড */
        .menu-container { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 15px; 
            padding: 0 20px; 
        }
        
        .menu-card { 
            background: white; 
            height: 110px; 
            border-radius: 20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            text-decoration: none; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.08); 
            transition: 0.3s;
            border: 1px solid #eee;
        }

        .menu-card:active { transform: scale(0.95); }
        .menu-card i { font-size: 32px; margin-bottom: 10px; }
        .menu-card span { font-size: 15px; font-weight: bold; color: #333; }

        .topup { color: #27ae60; }
        .withdraw { color: #e67e22; }
        .service { color: #8e44ad; }
        .gift { color: #d63031; }

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: white; display: flex; justify-content: space-around; padding: 12px 0; border-top: 1px solid #ddd; z-index: 1000; }
        .nav-item { text-align: center; text-decoration: none; color: #888; font-size: 12px; }
        .nav-item i { display: block; font-size: 22px; color: #1a2c5e; margin-bottom: 3px; }
        .nav-item.active { color: #1a2c5e; font-weight: bold; }
        .nav-item.active i { color: #d63031; }
    </style>
</head>
<body>

<div class="header-bg">
    <div class="profile-img"><i class="fas fa-user-circle"></i></div>
    <b>ID: <?php echo $u_id; ?></b>
    <p style="margin: 5px 0 0; font-size: 14px; opacity: 0.8;"><?php echo isset($user['name']) ? $user['name'] : 'Ubaidullah'; ?></p>
</div>

<div class="status-container">
    <div class="status-box">
        <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png" width="30" style="margin-bottom: 5px;">
        <div style="font-size: 11px; color: #666;">মোট টপ আপ</div>
        <div style="font-size: 15px; font-weight: bold; color: #27ae60;">৳ <?php echo number_format($dep_amount, 2); ?></div>
    </div>

    <div class="status-box">
        <img src="https://cdn-icons-png.flaticon.com/512/2721/2721113.png" width="30" style="margin-bottom: 5px;">
        <div style="font-size: 11px; color: #666;">মোট উইথড্রয়াল</div>
        <div style="font-size: 15px; font-weight: bold; color: #e74c3c;">৳ <?php echo number_format($wit_amount, 2); ?></div>
    </div>
</div>

<div class="menu-container">
    <a href="deposit.php" class="menu-card">
        <i class="fas fa-wallet topup"></i>
        <span>টপ আপ</span>
    </a>
    <a href="withdraw.php" class="menu-card">
        <i class="fas fa-hand-holding-usd withdraw"></i>
        <span>উইথড্রয়াল</span>
    </a>
    <a href="edit_profile.php" class="menu-card">
        <i class="fas fa-user-cog" style="color: #2980b9;"></i>
        <span>অ্যাকাউন্ট</span>
    </a>
    <a href="packages.php" class="menu-card">
        <i class="fas fa-gem service"></i>
        <span>পরিষেবা</span>
    </a>
    <a href="gift_code.php" class="menu-card" style="grid-column: span 2; height: 90px; flex-direction: row; gap: 15px;">
        <i class="fas fa-gift gift" style="margin-bottom: 0;"></i>
        <span>গিফট কোড রিডিম করুন</span>
    </a>
</div>

<div style="margin: 20px;">
    <a href="logout.php" style="display: block; text-align: center; padding: 15px; background: #ff4757; color: white; text-decoration: none; border-radius: 15px; font-weight: bold; box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3);">লগআউট করুন</a>
</div>

<div class="bottom-nav">
    <a href="index.php" class="nav-item"><i class="fas fa-home"></i>হোম</a>
    <a href="packages.php" class="nav-item"><i class="fas fa-shopping-cart"></i>প্যাকেজ</a>
    <a href="gift_code.php" class="nav-item"><i class="fas fa-gift"></i>গিফট</a>
    <a href="profile.php" class="nav-item active"><i class="fas fa-user"></i>প্রোফাইল</a>
</div>

</body>
</html>
