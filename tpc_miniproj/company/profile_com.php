<?php

//User not logged in : Redirect to index.php
include_once("../safe.php");
redirect_to_index("company");

//Including connection
include_once('../connection.php');

//Connecting to database
$con = getDB();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     //Checkign if all parameters passed
//     if (!isset($_POST["phone"])) {
//         $_SESSION['log_msg'] = "Please fill all the required fields. Names cannot be empty strings";
//     } else if ($_POST["phone"] != $_SESSION["phone"]) {

//         //Querying user details
//         $query = "SELECT `rollno`, `phone` FROM `student` WHERE `rollno` = ?";

//         $stmt = $con->prepare($query);
//         $stmt->bind_param('s', $_SESSION['rollno']);
//         $stmt->execute();
//         $stmt->store_result();

//         // If user exists
//         if ($stmt->num_rows() == 0) {
//             $_SESSION['log_msg'] =  "ERROR: User does not exist.";
//         } else {

//             $stmt->bind_result($rollno, $phone);
//             $stmt->fetch();

//             $phone = $_POST['phone'];

//             // Update user in database

//             $update_query = "UPDATE `student`
//                 SET `phone` = '$phone'
//                 WHERE `rollno` = '$rollno'";

//             $result = mysqli_query($con, $update_query);

//             if ($result) {
//                 // If update successful, also update session variables
//                 $_SESSION['log_msg'] = "Phone No. Updated Successfully";
//                 $_SESSION['phone'] = $phone;
//             } else {
//                 $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
//             }
//         }

//         $stmt->close();
//     }
// }

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

</head>

<body>

    <h4>Profile</h4>

    <!-- Printing log message -->
    <span style="color:red;"><?= $log ?></span><br>

    username: <?= $_SESSION['username'] ?>
    <br>

    Company Name: <?= $_SESSION['com_name'] ?>
    <br>

    email: <?= $_SESSION['email'] ?>
    <br>

    Representative Person: <?= $_SESSION['rep_name'] ?>
    <br>

    Recruiting Since: <?= $_SESSION['recruit_yr'] ?>

    <form method="post" name="Edit Phone">
        Phone No.: <input placeholder="Phone No." name="phone" type="text" title="10-digit Phone No." value="<?= $_SESSION['phone'] ?>" pattern="\d\d\d\d\d\d\d\d\d\d" required>
        <button type="submit">Save</button>
        <br>
    </form>

    <span id='message'></span>
    <br>

    <a href='http://localhost/tpc_miniproj/change_password.php/'>Change Password</a>
    <br>

    <a href='http://localhost/tpc_miniproj/company/index.php'>Back to Home</a>

</body>

</html>