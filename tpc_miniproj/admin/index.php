<?php

//starting session

include_once("../safe.php");
redirect_to_index("admin");

//display any error / log messages
$log = '';

if (isset($_SESSION['log_msg'])) {
    $log = $_SESSION['log_msg'];

    //Unsetting log_msg so that it does not repeat on a reload
    unset($_SESSION['log_msg']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    Admin Home
    <br>
    Welcome, <?= $_SESSION['username'] ?>
    <br>

    <span style="color:red;"><?= $log ?></span><br>

    <a href="http://localhost/tpc_miniproj/change_password.php">Change Password</a>
    <a href="http://localhost/tpc_miniproj/logout.php">Log Out</a>

</body>

</html>