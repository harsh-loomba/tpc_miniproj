<?php

//starting session

include_once("../safe.php");
redirect_to_index("alumni");

$_SESSION['chk_utype'] = 'alumni';


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
    <h1>Alumni Home</h1>
    </div>
    <br>
    <div class="container">
    <span style="color:red;"><?= $log ?></span><br>
    </div>

    <div class="container">
    <a href="../profile_stud.php">Profile</a>
    </div>
    <br>
    
    <div class="container">
    <a href="placement.php">Add Placement Information</a>
    </div>
    <br>

    <div class="container">
    <a href="http://localhost/tpc_miniproj/logout.php">Log Out</a>
    </div>

</body>

</html>
