<!DOCTYPE html>
<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body{font-family: Arial; background: #f4f4f4; padding: 20px; padding-bottom: 80px;}
    .list-item{background: white; padding: 15px; margin-bottom: 10px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);}
    .logout{color: red; font-weight: bold; cursor: pointer; text-align: center; display: block; margin-top: 20px;}
    .footer { position: fixed; bottom: 0; width: 100%; background: white; display: flex; justify-content: space-around; padding: 10px 0; border-top: 1px solid #ddd; left:0; text-align: center;}
    .footer a { text-decoration: none; color: #555; font-size: 12px; }
</style></head>
<body>
    <h3 style="text-align: center;">সেটিংস</h3>
    
    <div class="list-item">
        <span>নাম:</span>
        <b>উবাইদুল্লাহ</b>
    </div>
    <div class="list-item">
        <span>মোবাইল:</span>
        <b>০১৭XXXXXXXX</b>
    </div>
    <div class="list-item" onclick="alert('শীঘ্রই আসছে')">
        <span>পাসওয়ার্ড পরিবর্তন</span>
        <b>></b>
    </div>
    
    <a href="login.php" class="logout">লগ আউট করুন</a>

    <div class="footer">
        <a href="index.php">🏠<br>হোম</a>
        <a href="deposit.php">💰<br>ডিপোজিট</a>
        <a href="refer.php">👥<br>রেফার</a>
        <a href="withdraw.php">💸<br>উইথড্র</a>
        <a href="settings.php" style="color:#007bff;">⚙️<br>সেটিং</a>
    </div>
</body></html>