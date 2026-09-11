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
    <title>লেনদেনের হিস্টরি</title>
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

        .history-container { margin: 20px; }
        .transaction-card { background: var(--card-bg); padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); margin-bottom: 15px; border-left: 5px solid var(--secondary-color); display: flex; justify-content: space-between; align-items: center; }
        .transaction-info h4 { margin: 0; color: var(--primary-color); font-size: 16px; }
        .transaction-info p { margin: 5px 0 0; font-size: 13px; color: var(--light-text); }
        .transaction-amount { font-size: 18px; font-weight: bold; color: green; } /* For positive transactions */
        .transaction-amount.expense { color: red; } /* For negative transactions/purchases */

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-bg); display: flex; justify-content: space-around; padding: 10px 0; border-top: 1px solid #eee; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); z-index: 1000; }
        .nav-item { text-align: center; text-decoration: none; color: var(--light-text); font-size: 12px; flex: 1; padding: 5px 0; }
        .nav-item i { font-size: 20px; display: block; margin-bottom: 3px; color: var(--primary-color); }
        .nav-item.active { color: var(--primary-color); font-weight: bold; }
        .nav-item.active i { color: var(--secondary-color); }
    </style>
</head>
<body>

<div class="header">
    <h2>আমার লেনদেনের হিস্টরি</h2>
</div>

<div class="history-container">
    <?php
    $transactions = mysqli_query($conn, "SELECT * FROM investments WHERE user_id='$u_id' ORDER BY date DESC");
    if(mysqli_num_rows($transactions) > 0){
        while($row = mysqli_fetch_assoc($transactions)){
            ?>
            <div class="transaction-card">
                <div class="transaction-info">
                    <h4><?php echo $row['package_name']; ?></h4>
                    <p>পরিমাণ: ৳ <?php echo number_format($row['amount'], 2); ?></p>
                    <p>তারিখ: <?php echo date('d M, Y h:i A', strtotime($row['date'])); ?></p>
                </div>
                <div class="transaction-amount expense">-৳ <?php echo number_format($row['amount'], 2); ?></div>
            </div>
            <?php
        }
    } else {
        echo "<div style='text-align:center; padding:30px; background:white; border-radius:15px; color:#999;'>কোনো লেনদেনের হিস্টরি নেই।</div>";
    }
    ?>
</div>

<div class="bottom-nav">
    <a href="index.php" class="nav-item"><i class="fas fa-home"></i><span>হোম</span></a>
    <a href="packages.php" class="nav-item"><i class="fas fa-boxes"></i><span>প্যাকেজ</span></a>
    <a href="transactions.php" class="nav-item active"><i class="fas fa-history"></i><span>হিস্টরি</span></a>
    <a href="profile.php" class="nav-item"><i class="fas fa-user-circle"></i><span>প্রোফাইল</span></a>
</div>

</body>
</html>
