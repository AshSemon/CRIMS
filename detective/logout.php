<?php
session_start();
include('../function.inc.php');
unset($_SESSION['DETECTIVE_IS_LOGIN']);
unset($_SESSION['DETECTIVE_USER']);
unset($_SESSION['DETECTIVE_ID']);
redirect('login.php');
?>