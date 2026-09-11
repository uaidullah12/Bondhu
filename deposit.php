<?php
include 'db.php';
session_start();

// লগইন চেক
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
} else {
    $u_id = '778270'; // আপনার আইডি
}

// ডাটা প্রসেস অংশ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $txid = mysqli_real_escape_string($conn, $_POST['transaction_id']);

    if($amount >= 500) {
        $sql = "INSERT INTO deposits (user_id, amount, method, transaction_id, status) VALUES ('$u_id', '$amount', '$method', '$txid', 'pending')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('আপনার রিকোয়েস্ট সফল হয়েছে! অ্যাডমিন চেক করে ব্যালেন্স অ্যাড করে দেবে।'); window.location='index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('৫০০ টাকার কম গ্রহণযোগ্য নয়।'); window.location='deposit.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>টপ আপ - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 15px; }
        .box { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); max-width: 400px; margin: 30px auto; }
        .header-title { text-align: center; color: #1a2c5e; font-size: 18px; font-weight: bold; margin-bottom: 25px; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px; }
        
        /* মেথড গ্রিড ডিজাইন */
        .method-grid { display: flex; justify-content: space-between; gap: 15px; margin-bottom: 25px; }
        .method-item { border: 2px solid #f0f2f5; border-radius: 12px; padding: 15px; cursor: pointer; text-align: center; width: 48%; transition: 0.3s; box-sizing: border-box; background: #fff; }
        .method-item img { width: 50px; height: 50px; object-fit: contain; display: block; margin: auto; border-radius: 8px; }
        .method-item span { display: block; margin-top: 10px; font-weight: bold; font-size: 14px; color: #444; }
        
        /* সক্রিয় মেথড হাইলাইট */
        .method-item.active { border-color: #1a2c5e; background: #f0f4ff; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(26, 44, 94, 0.1); }

        input { width: 100%; padding: 14px; margin: 10px 0; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-size: 15px; outline: none; transition: 0.3s; }
        input:focus { border-color: #1a2c5e; box-shadow: 0 0 5px rgba(26, 44, 94, 0.2); }

        .payment-info { display: none; background: #fffcf0; padding: 20px; border-radius: 12px; text-align: center; margin-top: 20px; border: 1px dashed #ffc107; animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .number-display { font-size: 22px; font-weight: bold; color: #d63031; margin: 12px 0; background: #fff; padding: 10px; border-radius: 8px; box-shadow: inset 0 0 5px rgba(0,0,0,0.05); border: 1px solid #eee; }
        
        button { width: 100%; background: #1a2c5e; color: white; padding: 15px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 15px; transition: 0.3s; }
        button:hover { background: #0d1763; transform: translateY(-2px); }
        .copy-info { font-size: 12px; color: #666; margin-bottom: 10px; line-height: 1.4; }
    </style>
</head>
<body>

<div class="box">
    <div class="header-title">টপ আপ মেথড সিলেক্ট করুন</div>
    
    <div class="method-grid">
        <div class="method-item" id="b-btn" onclick="showPayment('bkash', '01932201374')">
            <img src="https://admin.bikroy.com/static/content/images/bikroy/payment/bkash.png" alt="Bkash">
            <span>বিকাশ</span>
        </div>
        
        <div class="method-item" id="n-btn" onclick="showPayment('nagad', '01930103386')">
            <img src="https://freelogopng.com/images/all_img/1679248787Nagad-Logo.png" alt="Nagad">
            <span>নগদ</span>
        </div>
    </div>

    <form action="" method="POST" onsubmit="return validateForm()">
        <label style="font-size: 13px; font-weight: bold; color: #555; margin-left: 5px;">টাকার পরিমাণ (মিনিমাম ৫০০)</label>
        <input type="number" name="amount" id="amount" placeholder="৳ পরিমাণ লিখুন" required>
        
        <div id="payment-details" class="payment-info">
            <p id="msg" style="margin: 0; font-weight: bold; color: #333;">নিচের নম্বরে <span style="color: #1a2c5e;">Send Money</span> করুন:</p>
            <div class="number-display" id="num-show"></div>
            <p class="copy-info"><i class="fas fa-info-circle"></i> সেন্ড মানি করার পর ট্রানজেকশন আইডি (TrxID) নিচের বক্সে দিন।</p>
            
            <input type="text" name="transaction_id" placeholder="8N7X6W5..." required>
            <input type="hidden" name="method" id="pay-method">
            <button type="submit">পেমেন্ট নিশ্চিত করুন</button>
        </div>
    </form>
</div>

<script>
    function showPayment(method, number) {
        // সব আইটেম থেকে অ্যাক্টিভ ক্লাস রিমুভ করা
        document.querySelectorAll('.method-item').forEach(i => i.classList.remove('active'));
        
        // সিলেক্ট করা মেথডে অ্যাক্টিভ ক্লাস যোগ করা
        if(method == 'bkash') document.getElementById('b-btn').classList.add('active');
        else document.getElementById('n-btn').classList.add('active');

        // পেমেন্ট ডিটেইলস দেখানো
        document.getElementById('payment-details').style.display = 'block';
        document.getElementById('num-show').innerText = number;
        document.getElementById('pay-method').value = method;
        
        // অটো স্ক্রল
        document.getElementById('payment-details').scrollIntoView({ behavior: 'smooth' });
    }

    function validateForm() {
        var amount = document.getElementById('amount').value;
        if (amount < 500) {
            alert("দুঃখিত, ৫০০ টাকার নিচে টপ আপ করা যাবে না।");
            return false;
        }
        var method = document.getElementById('pay-method').value;
        if (!method) {
            alert("দয়া করে একটি পেমেন্ট মেথড সিলেক্ট করুন।");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
