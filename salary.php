<?php
include 'db.php';
$u_id = '123456'; // ইউজারের আইডি
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মাসিক বেতন ও বোনাস</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f1f2f6; margin: 0; padding: 15px; }
        .box { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .header-title { color: #1a2c5e; text-align: center; font-weight: bold; margin-bottom: 15px; }
        
        /* বোনাস কোড সেকশন */
        .bonus-input { display: flex; gap: 10px; margin-bottom: 20px; }
        .bonus-input input { flex: 1; padding: 12px; border: 2px solid #1a2c5e; border-radius: 10px; outline: none; }
        .bonus-input button { background: #1a2c5e; color: white; border: none; padding: 0 20px; border-radius: 10px; cursor: pointer; }

        /* বেতনের চার্ট */
        .salary-table { width: 100%; border-collapse: collapse; }
        .salary-table tr { border-bottom: 1px solid #eee; }
        .salary-table td { padding: 15px 10px; font-size: 14px; }
        .target { font-weight: bold; color: #333; }
        .amount { color: #2ecc71; font-weight: bold; text-align: right; }
        .badge { background: #e8f0fe; color: #1a2c5e; padding: 4px 8px; border-radius: 5px; font-size: 11px; }
    </style>
</head>
<body>

<div class="box">
    <div class="header-title"><i class="fas fa-gift"></i> বোনাস কোড দিন</div>
    <form action="process_bonus.php" method="POST" class="bonus-input">
        <input type="text" name="bonus_code" placeholder="কোডটি এখানে লিখুন..." required>
        <button type="submit">ক্লেম</button>
    </form>
</div>

<div class="box">
    <div class="header-title"><i class="fas fa-money-check-alt"></i> মাসিক বেতন চার্ট</div>
    <table class="salary-table">
        <tr>
            <td class="target">👤 ১৫ জন রেফার</td>
            <td class="amount">৳ ১,০০০ /মাস</td>
        </tr>
        <tr>
            <td class="target">👤 ৩০ জন রেফার</td>
            <td class="amount">৳ ২,০০০ /মাস</td>
        </tr>
        <tr>
            <td class="target">👤 ৪০ জন রেফার</td>
            <td class="amount">৳ ৩,০০০ /মাস</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 20px;">
                <div class="badge">স্পেশাল অফার</div>
                <p style="font-size: 13px; color: #666; margin-top: 5px;">
                    ৪০ জনের পর প্রতি ১০ জন রেফারে আরও <b>৳ ১,০০০</b> করে বেতন বৃদ্ধি পাবে!
                </p>
            </td>
        </tr>
    </table>
</div>

<p style="text-align:center; font-size: 12px; color: #888;">শর্তাবলী প্রযোজ্য। প্রতি মাসে টার্গেট পূরণ করতে হবে।</p>

</body>
</html>
