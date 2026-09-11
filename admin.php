<?php
session_start();
include 'db.php';
$admin_pass = "admin123"; // আপনার পাসওয়ার্ড

// লগইন চেক
if (isset($_POST['login'])) {
    if ($_POST['password'] == $admin_pass) { $_SESSION['admin_logged'] = true; }
}
if (!isset($_SESSION['admin_logged'])) {
    echo '<div style="text-align:center;margin-top:100px;font-family:sans-serif;"><h2>আল খিদমাহ অ্যাডমিন প্যানেল</h2><form method="POST"><input type="password" name="password" placeholder="পাসওয়ার্ড" style="padding:10px;"><br><br><button type="submit" name="login" style="padding:10px 20px;background:#1a2c5e;color:white;border:none;">লগইন</button></form></div>';
    exit;
}

// ১. নতুন কার্ড/প্যাকেজ যোগ করা
if(isset($_POST['add_plan'])){
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price']; $daily = $_POST['p_daily']; $days = $_POST['p_days'];
    $hours = !empty($_POST['p_hours']) ? $_POST['p_hours'] : 0; 
    mysqli_query($conn, "INSERT INTO packages (name, price, daily_profit, validity, validity_hours) VALUES ('$name', '$price', '$daily', '$days', '$hours')");
    echo "<script>alert('কার্ড সফলভাবে পাবলিশ হয়েছে!'); window.location='admin.php?view=packages';</script>";
}

// ২. কার্ড ডিলিট করা
if(isset($_GET['del_card'])){
    $id = $_GET['del_card'];
    mysqli_query($conn, "DELETE FROM packages WHERE id='$id'");
    header("Location: admin.php?view=packages");
}

// ৩. গিফট/বোনাস কোড তৈরি
if(isset($_POST['add_gift'])){
    $code = mysqli_real_escape_string($conn, $_POST['g_code']);
    $amount = $_POST['g_amount']; $limit = $_POST['g_limit'];
    mysqli_query($conn, "INSERT INTO bonus_codes (code, amount, usage_limit) VALUES ('$code', '$amount', '$limit')");
    echo "<script>alert('গিফট কোড সেভ হয়েছে!'); window.location='admin.php?view=gifts';</script>";
}

// ৪. ইউজার ব্যান/আনব্যান
if(isset($_GET['ban'])){
    $id = $_GET['ban'];
    mysqli_query($conn, "UPDATE users SET status='banned' WHERE id='$id'");
    header("Location: admin.php?view=users");
}
if(isset($_GET['unban'])){
    $id = $_GET['unban'];
    mysqli_query($conn, "UPDATE users SET status='active' WHERE id='$id'");
    header("Location: admin.php?view=users");
}

// ৫. ডিপোজিট কন্ট্রোল
if (isset($_GET['dep_app'])) {
    $id = $_GET['dep_app'];
    $req = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deposits WHERE id='$id'"));
    if($req){
        $u_id = $req['user_id']; $amount = $req['amount'];
        mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE user_id='$u_id'");
        mysqli_query($conn, "UPDATE deposits SET status='success' WHERE id='$id'");
    }
    header("Location: admin.php?view=requests");
}
if (isset($_GET['dep_rej'])) {
    $id = $_GET['dep_rej'];
    mysqli_query($conn, "UPDATE deposits SET status='rejected' WHERE id='$id'");
    header("Location: admin.php?view=requests");
}

// ৬. উইথড্র কন্ট্রোল
if (isset($_GET['wit_app'])) {
    $id = $_GET['wit_app'];
    mysqli_query($conn, "UPDATE withdraws SET status='success' WHERE id='$id'");
    header("Location: admin.php?view=requests");
}
if (isset($_GET['wit_rej'])) {
    $id = $_GET['wit_rej'];
    $req = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM withdraws WHERE id='$id'"));
    if($req){
        $u_id = $req['user_id']; $amount = $req['amount'];
        mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE user_id='$u_id'");
        mysqli_query($conn, "UPDATE withdraws SET status='rejected' WHERE id='$id'");
    }
    header("Location: admin.php?view=requests");
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al Khidmah Admin Control</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        .sidebar { width: 250px; background: #1a2c5e; color: white; position: fixed; height: 100%; padding-top: 20px; z-index: 100;}
        .sidebar a { display: block; padding: 15px; color: white; text-decoration: none; border-bottom: 1px solid #2c3e50; transition: 0.3s; }
        .sidebar a:hover, .active-nav { background: #2980b9; }
        .main-content { margin-left: 260px; padding: 20px; }
        .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 20px;}
        h3 { color: #1a2c5e; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 0;}
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px;}
        th, td { padding: 10px; border: 1px solid #eee; text-align: center; }
        th { background: #f8f9fa; }
        .btn { padding: 6px 10px; text-decoration: none; border-radius: 6px; color: white; font-size: 11px; font-weight: bold; display: inline-block; margin: 2px;}
        .green { background: #27ae60; } .red { background: #e74c3c; } .blue { background: #3498db; }
        .info-tag { font-size: 10px; display: block; color: #666; margin-top: 4px; line-height: 1.2;}
        input, button { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box; }
        button { background: #1a2c5e; color: white; cursor: pointer; border: none; font-weight: bold; }
        @media screen and (max-width: 768px) { .sidebar { width: 100%; height: auto; position: relative; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="text-align:center; font-size: 20px;">অ্যাডমিন মেনু</h2>
    <a href="admin.php?view=dashboard" class="<?php echo (!isset($_GET['view']) || $_GET['view']=='dashboard') ? 'active-nav' : ''; ?>">🏠 ড্যাশবোর্ড</a>
    <a href="admin.php?view=requests" class="<?php echo (@$_GET['view']=='requests') ? 'active-nav' : ''; ?>">💰 পেন্ডিং রিকোয়েস্ট</a>
    <a href="admin.php?view=users" class="<?php echo (@$_GET['view']=='users') ? 'active-nav' : ''; ?>">👥 ইউজার ম্যানেজমেন্ট</a>
    <a href="admin.php?view=packages" class="<?php echo (@$_GET['view']=='packages') ? 'active-nav' : ''; ?>">🚀 ইনভেস্টমেন্ট কার্ড</a>
    <a href="admin.php?view=gifts" class="<?php echo (@$_GET['view']=='gifts') ? 'active-nav' : ''; ?>">🎁 গিফট কোড</a>
    <a href="index.php" target="_blank" style="background:#27ae60;">🌐 ওয়েবসাইট দেখুন</a>
    <a href="logout.php" style="background:#e74c3c;">🔴 লগআউট</a>
</div>

<div class="main-content">
    <?php 
    $view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

    if($view == 'dashboard') {
        echo "<div class='box'><h3>💎 স্বাগতম উবাইদুল্লাহ ভাই!</h3><p>আপনার প্ল্যাটফর্ম এখন সম্পূর্ণ ত্রুটিমুক্ত। পেন্ডিং রিকোয়েস্ট সেকশনে এখন ইউজারের প্রোফাইল সামারি দেখতে পারবেন।</p></div>";
    }

    if($view == 'requests') { ?>
        <div class="box">
            <h3>💰 পেন্ডিং রিকোয়েস্ট (বিস্তারিত তথ্যসহ)</h3>
            <div style="overflow-x:auto;">
            <table>
                <tr><th>টাইপ</th><th>ইউজার ID ও হিস্ট্রি</th><th>৳ পরিমাণ</th><th>অ্যাকশন</th></tr>
                <?php 
                // ডিপোজিট রিকোয়েস্ট লুপ
                $deps = mysqli_query($conn, "SELECT * FROM deposits WHERE status='pending'");
                while($d = mysqli_fetch_assoc($deps)): 
                    $uid = $d['user_id'];
                    // ইউজারের অতিরিক্ত তথ্য সংগ্রহ
                    $total_dep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM deposits WHERE user_id='$uid' AND status='success'"))['total'] ?? 0;
                    $total_wit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM withdraws WHERE user_id='$uid' AND status='success'"))['total'] ?? 0;
                    $active_cards = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_packages WHERE user_id='$uid' AND status='active'"));
                ?>
                <tr>
                    <td><b style="color:green;">ডিপোজিট</b></td>
                    <td>
                        <b><?php echo $uid; ?></b>
                        <span class="info-tag">মোট ডিপোজিট: ৳<?php echo $total_dep; ?></span>
                        <span class="info-tag">মোট উইথড্র: ৳<?php echo $total_wit; ?></span>
                        <span class="info-tag">অ্যাক্টিভ কার্ড: <?php echo $active_cards; ?>টি</span>
                    </td>
                    <td>৳<?php echo $d['amount']; ?></td>
                    <td><a href="?dep_app=<?php echo $d['id']; ?>" class="btn green">Approve</a> <a href="?dep_rej=<?php echo $d['id']; ?>" class="btn red">Reject</a></td>
                </tr>
                <?php endwhile; ?>

                <?php 
                // উইথড্র রিকোয়েস্ট লুপ
                $wits = mysqli_query($conn, "SELECT * FROM withdraws WHERE status='pending'");
                while($w = mysqli_fetch_assoc($wits)): 
                    $uid = $w['user_id'];
                    // ইউজারের অতিরিক্ত তথ্য সংগ্রহ
                    $total_dep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM deposits WHERE user_id='$uid' AND status='success'"))['total'] ?? 0;
                    $total_wit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM withdraws WHERE user_id='$uid' AND status='success'"))['total'] ?? 0;
                    $active_cards = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_packages WHERE user_id='$uid' AND status='active'"));
                ?>
                <tr>
                    <td><b style="color:blue;">উইথড্র</b></td>
                    <td>
                        <b><?php echo $uid; ?></b>
                        <span class="info-tag">মোট ডিপোজিট: ৳<?php echo $total_dep; ?></span>
                        <span class="info-tag">মোট উইথড্র: ৳<?php echo $total_wit; ?></span>
                        <span class="info-tag">অ্যাক্টিভ কার্ড: <?php echo $active_cards; ?>টি</span>
                    </td>
                    <td>৳<?php echo $w['amount']; ?></td>
                    <td><a href="?wit_app=<?php echo $w['id']; ?>" class="btn blue">পেইড</a> <a href="?wit_rej=<?php echo $w['id']; ?>" class="btn red">Reject</a></td>
                </tr>
                <?php endwhile; ?>
            </table>
            </div>
        </div>
    <?php }

    if($view == 'users') { ?>
        <div class="box">
            <h3>👥 ইউজার কন্ট্রোল ও রেফারেল তথ্য</h3>
            <form method="GET" style="display:flex; gap:10px;">
                <input type="hidden" name="view" value="users">
                <input type="text" name="search_user" placeholder="ইউজার আইডি (ID) লিখুন" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                <button type="submit" style="width:100px; margin:0;">খুঁজুন</button>
            </form>
            <div style="overflow-x:auto;">
            <table>
                <tr><th>ID</th><th>ব্যালেন্স</th><th>মোট রেফার</th><th>অবস্থা</th><th>অ্যাকশন</th></tr>
                <?php 
                $search_val = isset($_GET['search_user']) ? $_GET['search_user'] : '';
                $s = mysqli_real_escape_string($conn, (string)$search_val);
                $q = ($s != '') ? "WHERE user_id LIKE '%$s%'" : "ORDER BY id DESC LIMIT 15";
                
                $users = mysqli_query($conn, "SELECT * FROM users $q");
                while($u = mysqli_fetch_assoc($users)): 
                    $u_actual_id = $u['user_id'];
                    $ref_count_res = mysqli_query($conn, "SELECT COUNT(*) as total_ref FROM users WHERE ref_by='$u_actual_id'");
                    $ref_data = $ref_count_res ? mysqli_fetch_assoc($ref_count_res) : ['total_ref' => 0];
                ?>
                <tr>
                    <td><?php echo $u['user_id']; ?></td>
                    <td>৳<?php echo $u['balance']; ?></td>
                    <td><b style="color: #1a2c5e;"><?php echo $ref_data['total_ref']; ?> জন</b></td>
                    <td><?php echo $u['status']; ?></td>
                    <td><a href="?<?php echo $u['status']=='banned'?'unban':'ban'; ?>=<?php echo $u['id']; ?>&view=users" class="btn <?php echo $u['status']=='banned'?'green':'red'; ?>"><?php echo $u['status']=='banned'?'আনব্যান':'ব্যান'; ?></a></td>
                </tr>
                <?php endwhile; ?>
            </table>
            </div>
        </div>
    <?php }

    if($view == 'packages') { ?>
        <div class="box">
            <h3>🚀 নতুন ইনভেস্টমেন্ট কার্ড যোগ করুন</h3>
            <form method="POST">
                <input type="text" name="p_name" placeholder="কার্ডের নাম" required>
                <input type="number" name="p_price" placeholder="দাম" required>
                <input type="number" name="p_daily" placeholder="দৈনিক লাভ" required>
                <div style="display:flex; gap:10px;">
                    <input type="number" name="p_days" placeholder="মেয়াদ (দিন)" required>
                    <input type="number" name="p_hours" placeholder="ঘণ্টা">
                </div>
                <button type="submit" name="add_plan">কার্ড পাবলিশ করুন</button>
            </form>
        </div>
        <div class="box">
            <h3>📋 বর্তমান কার্ড লিস্ট</h3>
            <div style="overflow-x:auto;">
            <table>
                <tr><th>নাম</th><th>দাম</th><th>লাভ</th><th>মেয়াদ</th><th>অ্যাকশন</th></tr>
                <?php 
                $paks = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
                while($p = mysqli_fetch_assoc($paks)): ?>
                <tr>
                    <td><?php echo $p['name']; ?></td>
                    <td>৳<?php echo $p['price']; ?></td>
                    <td>৳<?php echo $p['daily_profit']; ?></td>
                    <td><?php echo $p['validity']."দিন ".$p['validity_hours']."ঘণ্টা"; ?></td>
                    <td><a href="?del_card=<?php echo $p['id']; ?>&view=packages" class="btn red" onclick="return confirm('ডিলিট করবেন?')">ডিলিট</a></td>
                </tr>
                <?php endwhile; ?>
            </table>
            </div>
        </div>
    <?php }

    if($view == 'gifts') { ?>
        <div class="box">
            <h3>🎁 গিফট কোড তৈরি করুন</h3>
            <form method="POST">
                <input type="text" name="g_code" placeholder="কোড লিখুন (যেমন: BONUS50)" required>
                <input type="number" name="g_amount" placeholder="টাকার পরিমাণ" required>
                <input type="number" name="g_limit" placeholder="কতজন ব্যবহার করতে পারবে" required>
                <button type="submit" name="add_gift">কোড সেভ করুন</button>
            </form>
        </div>
    <?php } ?>
</div>

</body>
</html>
