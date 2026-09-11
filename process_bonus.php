<?php
include 'db.php';
$u_id = '123456'; 
$code = $_POST['bonus_code'];

$check = mysqli_query($conn, "SELECT * FROM bonus_codes WHERE code='$code'");
if(mysqli_num_rows($check) > 0){
    $data = mysqli_fetch_assoc($check);
    $bonus = $data['amount'];
    
    // ব্যালেন্স আপডেট
    mysqli_query($conn, "UPDATE users SET balance = balance + $bonus WHERE user_id='$u_id'");
    // একবার ব্যবহার হলে কোডটি ডিলিট করতে চাইলে নিচের লাইনটি আনকমেন্ট করুন
    // mysqli_query($conn, "DELETE FROM bonus_codes WHERE code='$code'");
    
    echo "<script>alert('অভিনন্দন! $bonus টাকা বোনাস পেয়েছেন।'); window.location='index.php';</script>";
} else {
    echo "<script>alert('ভুল বোনাস কোড!'); window.location='salary.php';</script>";
}
?>
