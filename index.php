<?php
session_start();
$_SESSION['loggedin'] = 0;
$_SESSION['userid'] = -1;
$_SESSION['username'] = " ";
$_SESSION['customerID'] = " ";
$_SESSION['URI'] = '';
header("Location: Motueka/index.php");