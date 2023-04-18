<?php

session_start();

//User not logged in : Redirect to index.php
if (!isset($_SESSION['loggedin'], $_SESSION['utype'])) {
    header('Location: http://localhost/tpc_miniproj/index.html');
    exit;
}
if (($_SESSION['loggedin'] == false) || (($_SESSION['utype'] != 'student') && ($_SESSION['utype'] != 'alumni'))) {
    header('Location: http://localhost/tpc_miniproj/index.html');
    exit;
}

//Including connection
include_once('connection.php');

//Connecting to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Checkign if all parameters passed
    if (!isset($_POST["phone"])) {
        $_SESSION['log_msg'] = "Please fill all the required fields. Names cannot be empty strings";
    } else if ($_POST["phone"] != $_SESSION["phone"]) {

        //Querying user details
        $query = "SELECT `rollno`, `phone` FROM `student` WHERE `rollno` = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_SESSION['rollno']);
        $stmt->execute();
        $stmt->store_result();

        // If user exists
        if ($stmt->num_rows() == 0) {
            $_SESSION['log_msg'] =  "ERROR: User does not exist.";
        } else {

            $stmt->bind_result($rollno, $phone);
            $stmt->fetch();

            $phone = $_POST['phone'];

            // Update user in database

            $update_query = "UPDATE `student`
                SET `phone` = '$phone'
                WHERE `rollno` = '$rollno'";

            $result = mysqli_query($con, $update_query);

            if ($result) {
                // If update successful, also update session variables
                $_SESSION['log_msg'] = "Phone No. Updated Successfully";
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

    <script>
        var get_branch = function() {
            var data = {
                AI: "Artificial Intelligence and Data Science",
                CB: "Chemical Engineering",
                CE: "Civil and Environmental Engineering",
                CS: "Computer Science and Engineering",
                EE: "Electrical and Electronics Engineering",
                MC: "Mathematics and Computing",
                ME: "Mechanical Engineering",
                MM: "Materials and Metallurgical Engineering",
                PH: "Engineering Physics",
            };
            var text = data['<?= $_SESSION['branch'] ?>'];
            if (text == undefined) {
                text = '';
            }
            document.getElementById('branch').innerHTML = text;
        }
    </script>
    <link rel="stylesheet" type="text/css" href="mvp.css"/>
</head>

<body>

    <h1>Profile</h1>

    <!-- Printing log message -->
    <span style="color:red;"><?= $log ?></span><br>

    <div class="container">

    Roll No: <?= $_SESSION['rollno'] ?>
    <br>
    <br>

    Course: <?= $_SESSION['course'] ?> <span id="branch"></span>
    <script>
        get_branch();
    </script>
    <br>
    <br>

    Graduation Year: <?= $_SESSION['grad_yr'] ?>
    <br>
    <br>

    Status:

    <?php
    if ($_SESSION['alumnus']) {
        echo "Alumnus";
    } else {
        echo "Student";
    }
    ?>
    <br>
    <br>

    Webmail: <?= $_SESSION['email'] ?>
    <br>
    <br>

    Name: <?= $_SESSION['first_name'] ?> <?= $_SESSION['middle_name'] ?> <?= $_SESSION['last_name'] ?>
    <br>
    <br>

    </div>

    <div class="form-center">
    <form method="post" name="Edit Phone">
        Phone No.: <input placeholder="Phone No." name="phone" type="text" title="10-digit Phone No." value="<?= $_SESSION['phone'] ?>" pattern="\d\d\d\d\d\d\d\d\d\d" required>
        <div class="center">
        <button type="submit">Save</button>
        </div>
    </form>
    </div>

    <span id='message'></span>
    <br>

    <div class="container">
    <a href='http://localhost/tpc_miniproj/change_password.php/'>Change Password</a>
    </div>
    <br>

    <div class="container">
    <?php
    if ($_SESSION['alumnus']) {
        echo "<a href='http://localhost/tpc_miniproj/alumni/index.php'>Back to Home</a>";
    } else {
        echo "<a href='http://localhost/tpc_miniproj/student/index.php'>Back to Home</a>";
    }
    ?>
    </div>

</body>

</html>