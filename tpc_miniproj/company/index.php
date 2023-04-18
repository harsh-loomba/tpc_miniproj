<?php

//starting session

include_once("../safe.php");
redirect_to_index("company");

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
        .container{
        width: 100%;
        text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../mvp.css"/>
</head>

<body>
    <h1>Company Home</h1>
    <br>

    <div class="container">
    <span style="color:red;"><?= $log ?></span>
    </div>
    <br>

    <div class="container">
    <a href="profile_com.php">Profile</a>
    </div>
    <br>

    <div class="container">
    <a href="com_job.php">Add Job</a>
    </div>
    <br>

    <div class="container">
    <a href="com_round.php">Add Placement Round Information</a>
    </div>
    <br>

    <div class="container">
    <a href="com_cutoff.php">Set Eligibility Criteria</a>
    </div>
    <br>

    <div class="container">
    <a href="../student_info_display.php">Student Information</a>
    </div>
    <br>

    <div class="container">
    <a href="http://localhost/tpc_miniproj/logout.php">Log Out</a>
    </div>

</body>

</html>