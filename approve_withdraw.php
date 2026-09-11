<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE withdraws SET status='completed' WHERE id='$id'");
        echo "<script>alert('পেমেন্ট সাকসেসফুল করা হয়েছে!'); window.location='manage_withdraws.php';</script>";
    } else {
        // রিজেক্ট করলে ইউজারের টাকা ফেরত দিতে হবে (যদি আগে কেটে নিয়ে থাকেন)
        $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM withdraws WHERE id='$id'"));
        $u_id = $data['user_id'];
        $amount = $data['amount'];
        mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE user_id='$u_id'");
        mysqli_query($conn, "UPDATE withdraws SET status='rejected' WHERE id='$id'");
        echo "<script>alert('উইথড্র বাতিল এবং টাকা ফেরত দেওয়া হয়েছে।'); window.location='manage_withdraws.php';</script>";
    }
}
?>
