<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = '123456'; 
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $txid = $_POST['transaction_id'];

    if($amount >= 500) {
        $sql = "INSERT INTO deposits (user_id, amount, method, transaction_id, status) VALUES ('$u_id', '$amount', '$method', '$txid', 'pending')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('আপনার রিকোয়েস্ট সফল হয়েছে! অ্যাডমিন চেক করে ব্যালেন্স অ্যাড করে দেবে।'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('৫০০ টাকার কম গ্রহণযোগ্য নয়।'); window.location='deposit.php';</script>";
    }
}
?>
