<?php

//starting session
session_start();

//display any error / log messages
$log = '';

if (isset($_SESSION['log_msg'])) {
    $log = $_SESSION['log_msg'];

    //Unsetting log_msg so that it does not repeat on a reload
    unset($_SESSION['log_msg']);
}

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
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Jobs</title>
</head>

<body>
    <div class="session">


        <!-- Register form -->

        <form method="post" action="" name="add_job">

            <h4>Add Jobs</h4>

            <!-- Printing log message -->
            <span style="color:red;"><?= $log ?></span>
            <br>

            <input placeholder="Field" type="text" name="field" required />
            <br>

            <input placeholder="Position" type="text" name="position" required />
            <br>

            <input placeholder="Package" type="number" name="package" required />
            <br>

            <button type="submit">Add Job</button>
            <br>

            <a href="index.php">Back to Home</a>
    </div>
</body>

</html>