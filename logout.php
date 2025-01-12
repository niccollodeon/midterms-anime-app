<?php
session_start();
$_SESSION['username'] = '';
$_SESSION['account_type'] = '';
$_SESSION['user_id'] = '';
session_unset();
header('location:login.php');
?>