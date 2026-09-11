<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// লগইন করা ইউজারের আইডি নেওয়া
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
} else {
    $u_id = '778270'; 
}

// ইউজার ডাটা চেক - এখানে আপনার ডাটাবেস অনুযায়ী id অথবা user_id ব্যবহার করা হয়েছে
$user_query = mysqli_query($conn, "SELECT balance FROM users WHERE id='$u_id' OR user_id='$u_id' LIMIT 1"); 
$user_data = mysqli_fetch_assoc($user_query);
$current_balance = isset($user_data['balance']) ? (float)$user_data['balance'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = (float)$_POST['amount'];
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);

    date_default_timezone_set("Asia/Dhaka");
    $current_hour = date('H');
    $today = date('Y-m-d');

    // দিনে একবার উইথড্র করার চেক (অতিরিক্ত ফিচার)
    $check_today = mysqli_query($conn, "SELECT id FROM withdraws WHERE user_id='$u_id' AND DATE(date)='$today'");
    
    if ($current_hour < 10 || $current_hour >= 17) {
        echo "<script>alert('দুঃখিত! উইথড্র করার সময় সকাল ১০টা থেকে বিকাল ৫টা পর্যন্ত।'); window.location='withdraw.php';</script>";
    } elseif ($amount < 500) {
        echo "<script>alert('সর্বনিম্ন ৫০০ টাকা উইথড্র করা যাবে।');</script>";
    } elseif ($amount > $current_balance) {
        echo "<script>alert('পর্যাপ্ত ব্যালেন্স নেই।');</script>";
    } elseif (mysqli_num_rows($check_today) > 0) {
        echo "<script>alert('দুঃখিত! আপনি দিনে একবারের বেশি উইথড্র করতে পারবেন না।');</script>";
    } else {
        $new_balance = $current_balance - $amount;
        $update_query = mysqli_query($conn, "UPDATE users SET balance = '$new_balance' WHERE id='$u_id' OR user_id='$u_id'");
        $insert_query = mysqli_query($conn, "INSERT INTO withdraws (user_id, amount, status) VALUES ('$u_id', '$amount', 'pending')");
        
        if ($update_query && $insert_query) {
            echo "<script>alert('উইথড্র রিকোয়েস্ট সফল হয়েছে!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>উইথড্র ব্যালেন্স - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: white; width: 90%; max-width: 400px; padding: 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; }
        .header { background: #1a237e; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .balance-box { background: #e8eaf6; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #1a237e; }
        .balance-box span { display: block; font-size: 14px; color: #555; }
        .balance-box strong { font-size: 22px; color: #1a237e; }
        .input-group { text-align: left; margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .input-group input, .input-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 16px; }
        .btn-withdraw { background: #1a237e; color: white; border: none; width: 100%; padding: 15px; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-withdraw:hover { background: #0d47a1; }
        .note { font-size: 13px; color: #d32f2f; margin-top: 15px; font-weight: bold; line-height: 1.5; }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <h2 style="margin:0;"><i class="fas fa-wallet"></i> উইথড্রয়াল</h2>
    </div>

    <div class="balance-box">
        <span>আপনার বর্তমান ব্যালেন্স</span>
        <strong>৳ <?php echo number_format($current_balance, 2); ?></strong>
    </div>

    <form method="post">
        <div class="input-group">
            <label><i class="fas fa-money-bill-wave"></i> উইথড্র পরিমাণ</label>
            <input type="number" name="amount" min="500" required placeholder="৳ ৫০০ এর বেশি">
        </div>

        <div class="input-group">
            <label><i class="fas fa-university"></i> পেমেন্ট মেথড</label>
            <select name="method">
                <option value="bkash">বিকাশ (Personal)</option>
                <option value="nagad">নগদ (Personal)</option>
            </select>
        </div>

        <div class="input-group">
            <label><i class="fas fa-phone-alt"></i> আপনার নাম্বার</label>
            <input type="text" name="number" required placeholder="০১৭xxxxxxxx">
        </div>

        <button type="submit" class="btn-withdraw">রিকোয়েস্ট পাঠান</button>
    </form>

    <div class="note">
        <i class="fas fa-info-circle"></i> সকাল ১০টা থেকে বিকাল ৫টার মধ্যে উইথড্র করুন।<br>
        <i class="fas fa-history"></i> দিনে শুধুমাত্র একবার টাকা তোলা যাবে।<br>
        <i class="fas fa-clock"></i> ২-৭২ ঘণ্টার মধ্যে পেমেন্ট সম্পন্ন হবে।
    </div>
</div>

</body>
</html>
