<style>
    .bottom-nav { 
        position: fixed; 
        bottom: 0; 
        width: 100%; 
        background: #1a2c5e; 
        display: flex; 
        justify-content: space-around; 
        padding: 12px 0; 
        border-top: 1px solid rgba(255,255,255,0.1); 
        z-index: 1000;
    }
    .nav-link { text-align: center; color: #a4b0be; text-decoration: none; font-size: 11px; }
    .nav-link i { font-size: 20px; display: block; margin-bottom: 3px; }
    .nav-link.active { color: #fdbb2d; }
</style>

<div class="bottom-nav">
    <a href="index.php" class="nav-link"><i class="fas fa-home"></i>হোম</a>
    <a href="invest.php" class="nav-link"><i class="fas fa-chart-bar"></i>বিনিয়োগ</a>
    <a href="salary.php" class="nav-link"><i class="fas fa-money-bill-wave"></i>বেতন</a>
    <a href="team.php" class="nav-link"><i class="fas fa-users"></i>দল</a>
    <a href="profile.php" class="nav-link"><i class="fas fa-user-circle"></i>আমার</a>
</div>