<?php
session_start();

//Logout
session_destroy();

// Redirect to the login page
//Restart session
session_start();
//Set log message
$_SESSION['log_msg'] = "Logged out successfully!";
header('Location: index.php');
