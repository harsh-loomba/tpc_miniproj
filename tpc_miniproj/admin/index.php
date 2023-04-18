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
    <style>
        h1 {text-align: center;}
        h3 {text-align: center;}
        .container{
        width: 100%;
        text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../mvp.css" />
</head>

<body>
    <div class="container">
    <h1>Admin Home</h1>
    <br>
    <h3>Welcome, <?= $_SESSION['username'] ?></h3>
    </div>
    <br>

    <span style="color:red;"><?= $log ?></span><br>

    <div class="container">
    <a href="http://localhost/tpc_miniproj/change_password.php">Change Password</a>
    <a href="http://localhost/tpc_miniproj/logout.php">Log Out</a>
    </div>

</body>

</html>