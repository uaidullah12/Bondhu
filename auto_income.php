<?php
include 'db.php';

// গোল্ড এবং সিলভার কার্ডের ইনকাম রেট
$packages = [
    'গোল্ড কার্ড' => 200.00,
    'সিলভার কার্ড' => 100.00
];

$today = date('Y-m-d');

// আপনার active ইনভেস্টমেন্টগুলো চেক করা
$query = mysqli_query($conn, "SELECT * FROM investments WHERE status='active'");

while ($row = mysqli_fetch_assoc($query)) {
    $id = $row['id'];
    $u_id = $row['user_id'];
    $pkg_name = $row['package_name'];
    $daily_income = isset($packages[$pkg_name]) ? $packages[$pkg_name] : 0;

    if ($daily_income > 0) {
        // আজ অলরেডি ইনকাম পেয়েছে কি না চেক করা
        $check = mysqli_query($conn, "SELECT id FROM income_log WHERE user_id='$u_id' AND date='$today' AND investment_id='$id'");
        
        if (mysqli_num_rows($check) == 0) {
            // ইউজারের ব্যালেন্স বাড়ানো
            mysqli_query($conn, "UPDATE users SET balance = balance + $daily_income WHERE user_id='$u_id'");
            // ইনকাম লগ ইনসার্ট করা
            mysqli_query($conn, "INSERT INTO income_log (user_id, investment_id, amount, date) VALUES ('$u_id', '$id', '$daily_income', '$today')");
        }
    }
}
echo "আজকের ইনকাম সফলভাবে যোগ হয়েছে!";
?>
