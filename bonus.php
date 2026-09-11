<?php
session_start();
include 'db.php';

// আপনার লগইন সেশন অনুযায়ী মোবাইল নম্বরটি সংগ্রহ করা
// আপনার সিস্টেমে যদি সেশন নাম 'number' না হয়ে 'phone' হয়, তবে এটি চেক করবেন
$u_phone = $_SESSION['number'] ?? $_SESSION['phone']; 

if (isset($_POST['apply_code'])) {
    $user_code = mysqli_real_escape_string($conn, $_POST['gift_code']);

    // ১. বোনাস কোডটি ডাটাবেজ থেকে খুঁজে বের করা
    $res = mysqli_query($conn, "SELECT * FROM bonus_codes WHERE code='$user_code'");
    $code_data = mysqli_fetch_assoc($res);

    if (!$code_data) {
        echo "<script>alert('ভুল কোড! সঠিক কোডটি দিন।');</script>";
    } else {
        $amount = $code_data['amount'];
        $expiry = $code_data['expiry_date'];
        $limit = $code_data['usage_limit'];
        $status = $code_data['status'];
        $current_time = date('Y-m-d H:i:s');

        // ২. মেয়াদ চেক করা
        if (!empty($expiry) && $current_time > $expiry) {
            echo "<script>alert('দুঃখিত! এই কোডটির মেয়াদ শেষ।');</script>";
        } 
        // ৩. ব্যবহারের ধরন চেক (সিঙ্গেল ইউজ কি না)
        else if ($limit == 'single' && $status == 'used') {
            echo "<script>alert('দুঃখিত! এই কোডটি ইতিমধ্যে ব্যবহৃত হয়েছে।');</script>";
        } 
        else {
            // ৪. ব্যালেন্স আপডেট (সরাসরি নম্বর দিয়ে)
            // আমরা নম্বর (number) এবং ফোন (phone) দুই কলামেই চেক করবো যাতে মিস না হয়
            $update_sql = "UPDATE users SET balance = balance + $amount WHERE number='$u_phone' OR phone='$u_phone'";
            mysqli_query($conn, $update_sql);
            
            if (mysqli_affected_rows($conn) > 0) {
                // ৫. সফল হলে স্ট্যাটাস আপডেট
                if ($limit == 'single') {
                    mysqli_query($conn, "UPDATE bonus_codes SET status='used' WHERE code='$user_code'");
                }
                echo "<script>alert('অভিনন্দন! আপনি ৳$amount বোনাস পেয়েছেন।'); window.location='index.php';</script>";
            } else {
                // যদি সেশন নম্বর ডাটাবেজের সাথে না মিলে
                echo "<script>alert('ত্রুটি: আপনার একাউন্ট পাওয়া যায়নি। সেশন নম্বর: $u_phone');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>গিফট রিডিম - আল খিদমাহ</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; text-align: center; }
        .box { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 400px; margin: auto; margin-top: 50px; }
        input { width: 100%; padding: 15px; margin: 15px 0; border: 2px dashed #1a2c5e; border-radius: 10px; box-sizing: border-box; font-size: 18px; text-align: center; outline: none;}
        button { width: 100%; background: #1a2c5e; color: white; padding: 15px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color: #1a2c5e;">🎁 গিফট রিডিম</h2>
        <p style="color: #666;">কোড দিয়ে ব্যালেন্স বাড়িয়ে নিন</p>
        <form method="POST">
            <input type="text" name="gift_code" placeholder="কোডটি এখানে লিখুন" required>
            <button type="submit" name="apply_code">বোনাস সংগ্রহ করুন</button>
        </form>
    </div>
</body>
</html>
