<?php
session_start();
include('../function.inc.php');
unset($_SESSION['ADMIN_IS_LOGIN']);
unset($_SESSION['ADMIN_USER']);
unset($_SESSION['ADMIN_USER_NAME']);
unset($_SESSION['ADMIN_ID']);
redirect('login.php');
?>