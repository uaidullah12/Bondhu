<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>রেজিস্ট্রেশন - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .reg-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 90%; max-width: 400px; text-align: center; }
        .logo { font-size: 30px; color: #1a2a6c; margin-bottom: 10px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-size: 16px; }
        .btn-reg { background: linear-gradient(to right, #1a2a6c, #b21f1f); color: white; border: none; width: 100%; padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .login-link { margin-top: 15px; display: block; color: #666; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<div class="reg-card">
    <div class="logo"><i class="fas fa-user-plus"></i></div>
    <h2 style="color: #333;">নতুন একাউন্ট খুলুন</h2>
    <p style="color: #777; font-size: 14px;">আল খিদমাহ ইনভেস্টমেন্টে আপনাকে স্বাগতম</p>
    
    <form action="process_reg.php" method="POST">
        <input type="text" name="name" placeholder="আপনার পূর্ণ নাম" required>
        <input type="number" name="phone" placeholder="আপনার মোবাইল নম্বর" required>
        <input type="password" name="password" placeholder="একটি শক্তিশালী পাসওয়ার্ড" required>
        <input type="text" name="ref_by" placeholder="রেফার কোড (যদি থাকে)" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : ''; ?>">
        
        <button type="submit" class="btn-reg">একাউন্ট তৈরি করুন</button>
    </form>
    
    <a href="login.php" class="login-link">আগেই একাউন্ট আছে? লগ-ইন করুন</a>
</div>

</body>
</html>