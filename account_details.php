<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার অ্যাকাউন্ট - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding-bottom: 80px; }
        .header { background: #1a2c5e; color: white; padding: 20px; text-align: center; }
        .info-container { background: white; margin: 15px; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .info-row { display: flex; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid #eee; }
        .info-row:last-child { border-bottom: none; }
        .label { color: #666; font-size: 14px; }
        .value { color: #333; font-weight: bold; font-size: 14px; }
        .logout-btn { background: #ff4757; color: white; display: block; margin: 20px; padding: 15px; text-align: center; text-decoration: none; border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <i class="fas fa-user-circle" style="font-size: 50px; margin-bottom: 10px;"></i>
    <h2>অ্যাকাউন্ট তথ্য</h2>
</div>

<div class="info-container">
    <div class="info-row">
        <span class="label">ইউজার আইডি</span>
        <span class="value">914202</span>
    </div>
    <div class="info-row">
        <span class="label">মোবাইল নম্বর</span>
        <span class="value">01XXXXXXXXX</span>
    </div>
    <div class="info-row">
        <span class="label">সদস্য লেভেল</span>
        <span class="value" style="color: #fdbb2d;">ভিআইপি ১</span>
    </div>
    <div class="info-row">
        <span class="label">নিবন্ধন তারিখ</span>
        <span class="value">০১ জানুয়ারি ২০২৬</span>
    </div>
</div>

<a href="logout.php" class="logout-btn">লগ আউট করুন</a>

<?php include 'footer.php'; ?>

</body>
</html>