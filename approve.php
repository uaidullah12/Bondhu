<?php
// ... পেমেন্ট অ্যাপ্রুভ হওয়ার পরের অংশ ...

$deposit_amount = 1000; // উদাহরণস্বরূপ ১০০০ টাকা
$u_id = 'ইউজারের_আইডি';

// ১. প্রথম লেভেল (৮% বোনাস)
$level1_bonus = $deposit_amount * 0.08;
mysqli_query($conn, "UPDATE users SET balance = balance + $level1_bonus WHERE user_id = (SELECT refer FROM users WHERE user_id = '$u_id')");

// ২. দ্বিতীয় লেভেল (৩% বোনাস)
$level2_bonus = $deposit_amount * 0.03;
mysqli_query($conn, "UPDATE users SET balance = balance + $level2_bonus WHERE user_id = (SELECT refer FROM users WHERE user_id = (SELECT refer FROM users WHERE user_id = '$u_id'))");

// ৩. তৃতীয় লেভেল (২% বোনাস)
$level3_bonus = $deposit_amount * 0.02;
mysqli_query($conn, "UPDATE users SET balance = balance + $level3_bonus WHERE user_id = (SELECT refer FROM users WHERE user_id = (SELECT refer FROM users WHERE user_id = (SELECT refer FROM users WHERE user_id = '$u_id')))");
?>
