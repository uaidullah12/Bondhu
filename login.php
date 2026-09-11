<?php
include 'db.php';
session_start();

if (isset($_POST['login_btn'])) {
    $input = mysqli_real_escape_string($conn, $_POST['number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // আমরা সব অপশন রাখছি যাতে কোনো কলামের জন্য এরর না আসে
    // আপনার ডাটাবেজে phone অথবা number যা-ই থাকুক, এটা দিয়ে লগইন হবে
    $query = "SELECT * FROM users WHERE (phone='$input' OR user_id='$input' OR number='$input') AND password='$password' LIMIT 1";
    $res = mysqli_query($conn, $query);
    
    if ($res && mysqli_num_rows($res) > 0) {
        $user_data = mysqli_fetch_assoc($res);
        // সেশনে ইউজার আইডি বা ফোন নম্বর সেভ রাখা হচ্ছে
        $_SESSION['user_id'] = isset($user_data['user_id']) ? $user_data['user_id'] : (isset($user_data['phone']) ? $user_data['phone'] : $user_data['id']); 
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('ভুল মোবাইল নম্বর বা পাসওয়ার্ড!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - আল খিদমাহ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Arial', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px 30px; border-radius: 25px; width: 90%; max-width: 350px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-top: 5px solid #1a2c5e; }
        
        h2 { color: #1a2c5e; margin-bottom: 25px; font-size: 26px; font-weight: bold; }
        .input-group { position: relative; margin-bottom: 15px; }
        .input-group i { position: absolute; left: 15px; top: 15px; color: #1a2c5e; }
        
        input { width: 100%; padding: 14px 14px 14px 45px; border: 1.5px solid #eee; border-radius: 12px; box-sizing: border-box; font-size: 16px; outline: none; transition: 0.3s; background: #f9f9f9; }
        input:focus { border-color: #1a2c5e; background: white; }
        
        button { width: 100%; background: #1a2c5e; color: white; padding: 14px; border: none; border-radius: 12px; font-weight: bold; font-size: 18px; cursor: pointer; transition: 0.3s; margin-top: 10px; box-shadow: 0 5px 15px rgba(26, 44, 94, 0.3); }
        button:active { transform: scale(0.98); }
        
        .reg-link { margin-top: 25px; font-size: 15px; color: #666; }
        .reg-link a { color: #1a2c5e; text-decoration: none; font-weight: bold; border-bottom: 2px solid #1a2c5e; padding-bottom: 2px; }
    </style>
</head>
<body>
    <div class="login-box">
        <i class="fas fa-user-shield" style="font-size: 50px; color: #1a2c5e; margin-bottom: 10px;"></i>
        <h2>লগইন করুন</h2>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-phone-alt"></i>
                <input type="text" name="number" placeholder="মোবাইল নম্বর" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="পাসওয়ার্ড" required>
            </div>
            <button type="submit" name="login_btn">লগইন করুন</button>
        </form>
        <div class="reg-link">
            অ্যাকাউন্ট নেই? <a href="register.php">নতুন অ্যাকাউন্ট খুলুন</a>
        </div>
    </div>
</body>
</html>
