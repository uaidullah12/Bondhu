<?php
// রেফারেল কমিশনের হিসাব
function addReferralCommission($userId, $investAmount, $conn) {
    // লেভেল ১ (৮%)
    $level1_bonus = $investAmount * 0.08;
    // লেভেল ২ (৩%)
    $level2_bonus = $investAmount * 0.03;
    // লেভেল ৩ (২%)
    $level3_bonus = $investAmount * 0.02;

    // এখানে ডাটাবেজ আপডেট করার কোড থাকবে
    // উবাইদুল্লাহ, এই অংশটি আপনার ইউজার টেবিলের সাথে কানেক্ট করে দেবো।
}
?>