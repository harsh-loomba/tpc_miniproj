<?php

//starting session
session_start();

//display any error / log messages
$log = '';

//include connection.php
include_once('../connection.php');

//Connect to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //If all parameters present in post
    if (!isset(
        $_POST["field"],
        $_POST["position"],
        $_POST["package"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {
        $field = convert_input($_POST["field"]);
        $position = convert_input($_POST["position"]);
        $package = (int)filter_var($_POST["package"], FILTER_SANITIZE_NUMBER_INT);
        $username = $_SESSION['username'];

        //Registering

        $query =
            "INSERT INTO `company_job`
            (`username`,`field`, `position`, `package`)
            VALUES ('$username', '$field', '$position', '$package');";

        $result = mysqli_query($con, $query);

        if ($result) {
            $_SESSION['log_msg'] = "Job Added!";
        } else {
            $_SESSION['log_msg'] = "Server Error : Job not added.";
        }
    }

    $_POST = array();
}

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
    <title>Add Jobs</title>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <style>
        h1 {text-align: center;}
        .form-center {
            display:flex;
            justify-content:center;
        }
        .container{
            width: 100%;
            text-align: center;
        }
        .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        border: 3px solid #fff;;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="../mvp.css"/>
</head>

<body>
    <br>
    <div class="session">


        <!-- Register form -->
        <div class="form-center">
        <form method="post" action="" name="add_job">

            <h1>Add Jobs</h1>

            <!-- Printing log message -->
            <div class="container">
            <span style="color:red;"><?= $log ?></span>
            </div>
            <br>

            <input placeholder="Field" type="text" name="field" required size="30"/>
            <br>

            <input placeholder="Position" type="text" name="position" required size="30"/>
            <br>
            
            <div class="center">
            <input placeholder="Package" type="number" name="package" required/>
            </div>
            <br>

            <div class="center">
            <button type="submit">Add Job</button>
            </div>
            <br>

            <div class="container">
            <a href="index.php">Back to Home</a>
            </div>
        </form>
        </div>
    </div>
</body>

</html>