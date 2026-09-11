<?php
include 'db.php';
$requests = mysqli_query($conn, "SELECT * FROM deposits WHERE status='pending'");
?>

<style>
    body { font-family: sans-serif; padding: 20px; background: #eee; }
    .card { background: white; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-left: 5px solid #1a2c5e; }
    .btn { padding: 8px 15px; border-radius: 5px; border: none; color: white; font-weight: bold; cursor: pointer; }
    .btn-success { background: #27ae60; }
    .btn-danger { background: #e74c3c; }
</style>

<h2>পেন্ডিং ডিপোজিট রিকোয়েস্ট</h2>

<?php while($row = mysqli_fetch_assoc($requests)) { ?>
<div class="card">
    <p><b>ইউজার আইডি:</b> <?php echo $row['user_id']; ?></p>
    <p><b>টাকার পরিমাণ:</b> ৳<?php echo $row['amount']; ?></p>
    <p><b>মেথড:</b> <?php echo $row['method']; ?></p>
    <p><b>ট্রানজেকশন আইডি:</b> <?php echo $row['trx_id']; ?></p>
    <form action="approve_deposit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="submit" name="action" value="approve" class="btn btn-success">অ্যাপ্রুভ (Approve)</button>
        <button type="submit" name="action" value="reject" class="btn btn-danger">রিজেক্ট (Reject)</button>
    </form>
</div>
<?php } ?>
