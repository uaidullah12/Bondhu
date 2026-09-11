<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // লগআউট হয়ে লগইন পেজে চলে যাবে
exit();
?>
