<?php
include 'db.php';
$withdraws = mysqli_query($conn, "SELECT * FROM withdraws WHERE status='pending'");
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>উইথড্রয়াল ম্যানেজমেন্ট</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 20px; }
        .w-card { background: white; padding: 15px; border-radius: 12px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #ff4757; }
        .btn { padding: 10px 15px; border: none; border-radius: 5px; color: white; cursor: pointer; font-weight: bold; }
        .btn-pay { background: #27ae60; }
        .btn-cancel { background: #e74c3c; margin-left: 10px; }
    </style>
</head>
<body>
    <h2>উইথড্রয়াল রিকোয়েস্ট লিস্ট</h2>
    <?php while($row = mysqli_fetch_assoc($withdraws)) { ?>
    <div class="w-card">
        <p><b>ইউজার আইডি:</b> <?php echo $row['user_id']; ?></p>
        <p><b>টাকার পরিমাণ:</b> ৳<?php echo $row['amount']; ?></p>
        <p><b>নম্বর:</b> <?php echo $row['number']; ?> (<?php echo $row['method']; ?>)</p>
        <form action="approve_withdraw.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="action" value="approve" class="btn btn-pay">পেমেন্ট কমপ্লিট</button>
            <button type="submit" name="action" value="reject" class="btn btn-cancel">বাতিল করুন</button>
        </form>
    </div>
    <?php } ?>
</body>
</html>
