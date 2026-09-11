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
$current_balance = isset($user['balance']) ? $user['balance'] : 0;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আল খিদমাহ ডিজিটাল - হোম</title>
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
        
        .header { background: var(--primary-color); color: white; padding: 15px 20px; text-align: center; display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; font-size: 20px; }
        .header .user-id { font-size: 12px; opacity: 0.9; }

        /* ব্যালেন্স কার্ড */
        .balance-card { background: var(--card-bg); margin: 20px; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; }
        .balance-card p { margin: 0; color: var(--light-text); font-size: 14px; font-weight: bold; }
        .balance-card h1 { margin: 10px 0; color: var(--primary-color); font-size: 32px; }

        /* অ্যানিমেটেড ছবি */
        .animated-banner { 
            background: linear-gradient(135deg, #1a2c5e, #3a539b); 
            height: 180px; 
            margin: 20px; 
            border-radius: 15px; 
            overflow: hidden; 
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        .animated-banner img { width: 100%; height: 100%; object-fit: cover; position: absolute; animation: moveAnimation 15s infinite alternate ease-in-out; }
        @keyframes moveAnimation {
            0% { transform: scale(1) translateX(0); opacity: 0.9; }
            50% { transform: scale(1.05) translateX(5%); opacity: 1; }
            100% { transform: scale(1) translateX(0); opacity: 0.9; }
        }

        /* রেফার লিঙ্ক সেকশন */
        .refer-section { background: var(--card-bg); margin: 20px; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .refer-section h3 { margin-top: 0; color: var(--primary-color); font-size: 18px; }
        .refer-link-box { background: var(--bg-color); padding: 10px; border-radius: 10px; border: 1px dashed #ccc; margin-bottom: 10px; font-size: 14px; word-break: break-all; }
        .copy-btn { background: var(--secondary-color); color: white; padding: 8px 15px; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; display: block; width: fit-content; margin-top: 10px; }

        /* সক্রিয় কার্ড সেকশন স্টাইল */
        .section-title { margin: 20px; font-size: 18px; font-weight: bold; color: var(--primary-color); display: flex; align-items: center; gap: 8px; }
        .card-item { background: white; padding: 15px; border-radius: 12px; margin: 0 20px 10px; border-left: 5px solid var(--secondary-color); box-shadow: 0 3px 8px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .card-info b { display: block; font-size: 15px; }
        .card-info small { color: #888; font-size: 11px; }
        .status-tag { background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }

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
    <h2>আল খিদমাহ ডিজিটাল</h2>
    <span class="user-id">আইডি: <?php echo $u_id; ?></span>
</div>

<div class="balance-card">
    <p>মোট ইনকাম</p>
    <h1>৳ <?php echo number_format($current_balance, 2); ?></h1>
</div>

<div class="animated-banner">
    <img src="https://img.freepik.com/free-vector/digital-money-transfer-technology-background_1017-17454.jpg" alt="টাকা আনা-নেওয়া">
</div>

<div class="refer-section">
    <h3>আপনার রেফার লিংক</h3>
    <div class="refer-link-box" id="referLink">
        <?php echo "https://your_domain.com/register.php?ref=" . $u_id; ?>
    </div>
    <button class="copy-btn" onclick="copyReferLink()">কপি করুন</button>
</div>

<div class="section-title"><i class="fas fa-credit-card"></i> আমার সক্রিয় কার্ডসমূহ</div>
<div class="active-cards-container">
    <?php
    // টেবিল চেক করে ডাটা আনা
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'investments'");
    if(mysqli_num_rows($check_table) > 0) {
        $cards = mysqli_query($conn, "SELECT * FROM investments WHERE user_id='$u_id' AND status='active' ORDER BY id DESC");
        if(mysqli_num_rows($cards) > 0) {
            while($c = mysqli_fetch_assoc($cards)) {
                echo '<div class="card-item">
                        <div class="card-info">
                            <b>'.$c['package_name'].' (৳ '.$c['amount'].')</b>
                            <small>তারিখ: '.date('d M, Y', strtotime($c['date'])).'</small>
                        </div>
                        <div class="status-tag">সক্রিয়</div>
                      </div>';
            }
        } else {
            echo '<div style="text-align:center; padding:20px; color:#999; font-size:13px; background:white; border-radius:12px; margin: 0 20px;">আপনার কোনো সক্রিয় কার্ড নেই।</div>';
        }
    }
    ?>
</div>

<div class="bottom-nav">
    <a href="index.php" class="nav-item active"><i class="fas fa-home"></i><span>হোম</span></a>
    <a href="packages.php" class="nav-item"><i class="fas fa-boxes"></i><span>প্যাকেজ</span></a>
    <a href="transactions.php" class="nav-item"><i class="fas fa-history"></i><span>হিস্টরি</span></a>
    <a href="profile.php" class="nav-item"><i class="fas fa-user-circle"></i><span>প্রোফাইল</span></a>
</div>

<script>
    function copyReferLink() {
        var copyText = document.getElementById("referLink").textContent;
        var textarea = document.createElement("textarea");
        textarea.value = copyText.trim();
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("রেফার লিংক কপি করা হয়েছে!");
    }
</script>

</body>
</html>
