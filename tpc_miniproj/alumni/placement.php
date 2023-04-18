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
        $_POST["com_name"],
        $_POST["CTC"],
        $_POST["field_of_work"],
        $_POST["position"],
        $_POST["location"],
        $_POST["from_year"],
        $_POST["to_year"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {

        $rollno = $_SESSION['rollno'];

        $com_name = convert_input($_POST['com_name']);
        $CTC = (int)filter_var($_POST['CTC'], FILTER_SANITIZE_NUMBER_INT);
        $field_of_work = convert_input($_POST['field_of_work']);
        $position = convert_input($_POST['position']);
        $location = convert_input($_POST['location']);
        $from_year = (int)filter_var($_POST['from_year'], FILTER_SANITIZE_NUMBER_INT);
        $to_year = (int)filter_var($_POST['to_year'], FILTER_SANITIZE_NUMBER_INT);

        $query =
            "INSERT INTO `alumni_placement`
            (`rollno`, `com_name`, `CTC`, `field_of_work`, `position`, `location`, `from_yr`, `to_yr`)
            VALUES ('$rollno', '$com_name', '$CTC', '$field_of_work', '$position', '$location', '$from_year', '$to_year');";

        $result = mysqli_query($con, $query);

        if ($result) {
            $_SESSION['log_msg'] = "Placement information updated!";
        } else {
            $_SESSION['log_msg'] = "Server Error : Not added.";
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
    <title>Placements</title>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <form method="post" action="" name="placement">

        <span style="color:red;"><?= $log ?></span>
        <br>

        <input placeholder="Company Name" type="text" pattern=".{0,256}" name="com_name" required />
        <br>

        <input placeholder="CTC" type="number" name="CTC" />(Optional)
        <br>

        <input placeholder="Field of Work" type="text" pattern=".{0,256}" name="field_of_work" required />
        <br>

        <input placeholder="Position" type="text" pattern=".{0,256}" name="position" required />
        <br>

        <input placeholder="Location" type="text" pattern=".{0,256}" name="location" required />
        <br>

        From Year: <input id="from_year" name="from_year" type="number" min="2008" max="2099" step="1" required />
        <br>

        To Year: (leave empty if currently working) <input id="to_year" name="to_year" type="number" min="2008" max="2099" step="1" required />
        <br>

        <button type="submit">Add Placement Info</button>
        <br>

    </form>

    <a href="index.php">Back to Home</a>

</body>

</html>