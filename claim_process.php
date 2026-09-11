<?php
include 'db.php';
session_start();

// ১. অটো ফিক্স: ফাইলটি রান হওয়ামাত্র কলাম আছে কি না চেক করবে এবং না থাকলে তৈরি করবে
mysqli_query($conn, "ALTER TABLE investments ADD COLUMN IF NOT EXISTS last_claim_time DATETIME DEFAULT CURRENT_TIMESTAMP");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $inv_id = mysqli_real_escape_string($conn, $_POST['inv_id']);
    $u_id = $_SESSION['user_id'];

    // ২. ইনভেস্টমেন্ট তথ্য চেক
    $query = mysqli_query($conn, "SELECT * FROM investments WHERE id='$inv_id' AND user_id='$u_id'");
    $card = mysqli_fetch_assoc($query);

    if ($card) {
        // ৩. প্যাকেজ অনুযায়ী ইনকাম নির্ধারণ (আপনার রেট অনুযায়ী ঠিক করে নিন)
        $income = 0;
        if (strpos($card['package_name'], 'গোল্ড') !== false) {
            $income = 200.00;
        } else if (strpos($card['package_name'], 'সিলভার') !== false) {
            $income = 100.00;
        } else {
            $income = $card['daily_income']; // অথবা ডিফল্ট ইনকাম
        }

        // ৪. ব্যালেন্স আপডেট এবং ক্লেম টাইম আপডেট
        $update_user = mysqli_query($conn, "UPDATE users SET balance = balance + $income WHERE user_id='$u_id'");
        $update_inv = mysqli_query($conn, "UPDATE investments SET last_claim_time = NOW() WHERE id='$inv_id'");

        if ($update_user && $update_inv) {
            echo "<script>alert('৳ $income সফলভাবে আপনার ওয়ালেটে যোগ হয়েছে!'); window.location='index.php';</script>";
        } else {
            echo "এরর: " . mysqli_error($conn);
        }
    } else {
        echo "কার্ড পাওয়া যায়নি!";
    }
}
?>
