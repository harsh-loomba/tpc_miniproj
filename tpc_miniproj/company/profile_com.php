<?php

//User not logged in : Redirect to index.php
include_once("../safe.php");
redirect_to_index("company");

//Including connection
include_once('../connection.php');

//Connecting to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Checkign if all parameters passed
    if (!isset($_POST["com_name"], $_POST["email"], $_POST["rep_name"], $_POST["recruit_yr"], $_POST["phone"])) {
        $_SESSION['log_msg'] = "Please fill all the required fields. Names cannot be empty strings";
    } else if (
        ($_POST["com_name"] != $_SESSION["com_name"]) ||
        ($_POST["email"] != $_SESSION["email"]) ||
        ($_POST["rep_name"] != $_SESSION["rep_name"]) ||
        ($_POST["recruit_yr"] != $_SESSION["recruit_yr"]) ||
        ($_POST["phone"] != $_SESSION["phone"])
    ) {

        //Querying user details
        $query = "SELECT `username`, `email`, `com_name`, `rep_name`, `recruit_yr`, `phone` FROM `company` WHERE `username` = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $stmt->store_result();

        // If user exists
        if ($stmt->num_rows() == 0) {
            $_SESSION['log_msg'] =  "ERROR: User does not exist.";
        } else {

            $stmt->bind_result($username, $email, $com_name, $rep_name, $recruit_yr, $phone);
            $stmt->fetch();

            $email = $_POST['email'];
            $com_name = $_POST['com_name'];
            $rep_name = $_POST['rep_name'];
            $recruit_yr = $_POST['recruit_yr'];
            $phone = $_POST['phone'];

            // Update user in database

            $update_query = "UPDATE `company`
                SET 
                `email` = '$email',
                `com_name` = '$com_name',
                `rep_name` = '$rep_name',
                `recruit_yr` = '$recruit_yr',
                `phone` = '$phone'
                WHERE `username` = '$username'";

            $result = mysqli_query($con, $update_query);

            if ($result) {
                // If update successful, also update session variables
                $_SESSION['log_msg'] = "Details Updated Successfully";
                $_SESSION['email'] = $email;
                $_SESSION['com_name'] = $com_name;
                $_SESSION['rep_name'] = $rep_name;
                $_SESSION['recruit_yr'] = $recruit_yr;
                $_SESSION['phone'] = $phone;
            } else {
                $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
            }
        }

        $stmt->close();
    }
}

//Displaying log message
$log = '';

if (isset($_SESSION['log_msg'])) {
    $log = $_SESSION['log_msg'];
    unset($_SESSION['log_msg']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <style>
        h1 {text-align: center;}
        h3 {text-align: center;}
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

    <h1>Profile</h1>

    <!-- Printing log message -->
    <div class="container">
    <span style="color:red;"><?= $log ?></span>
    </div>
    <br>

    <div class="center">
    <h3>
    username: <?= $_SESSION['username'] ?>
    </h3>
    </div>
    <br>

    <div class="form-center">
    <form method="post" name="Edit Phone">

        Company Name: <input placeholder="Company Name" type="text" name="com_name" pattern=".{0,256}" title="Username should be between 8 to 100 characters." value="<?= $_SESSION['com_name'] ?>" required size="30"/>
        <br>

        Email: <input placeholder="Email" type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email address." value="<?= $_SESSION['email'] ?>" required size="30"/>
        <br>

        Representative Person: <input placeholder="Representative Name" type="text" name="rep_name" pattern="^[a-zA-Z][a-zA-Z\s]*$" value="<?= $_SESSION['rep_name'] ?>" title="Names cannot contain digits or special characters." required size="30"/>
        <br>

        Recruiting Since: <input id="recruit_yr" name="recruit_yr" type="number" min="2008" max="2099" step="1" value="<?= $_SESSION['recruit_yr'] ?>" required/>
        <br>

        Phone No.: <input placeholder="Phone No." name="phone" type="text" title="10-digit Phone No." value="<?= $_SESSION['phone'] ?>" pattern="\d\d\d\d\d\d\d\d\d\d" required size="30">
        <br>

        <div class="center">
        <button type="submit">Save</button>
        </div>
        <br>
    </form>
    </div>

    <span id='message'></span>
    <br>

    <div class="container">
    <a href='http://localhost/tpc_miniproj/change_password.php/'>Change Password</a>
    </div>
    <br>

    <div class="container">
    <a href='http://localhost/tpc_miniproj/company/index.php'>Back to Home</a>
    </div>

</body>

</html>