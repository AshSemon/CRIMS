<?php
session_start();
include('../function.inc.php');
unset($_SESSION['ARCHIVE_IS_LOGIN']);
unset($_SESSION['ARCHIVE_USER']);
unset($_SESSION['ARCHIVE_USER_NAME']);
unset($_SESSION['ARCHIVE_ID']);
redirect('login.php');
?>