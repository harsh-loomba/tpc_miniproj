<?php
session_start();

//User not logged in : Redirect to index.php
if (!isset($_SESSION['loggedin'])) {
    session_destroy();
    header('Location: http://localhost/tpc_miniproj/index.html');
    exit;
}

//Including connection
include_once('connection.php');

//Connecting to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Checkign if all parameters passed
    if (!isset($_POST["new_pass"], $_POST["confirm_pass"], $_POST['password'])) {
        $_SESSION['log_msg'] = "Please fill all the required fields. Names cannot be empty strings";
    } else {

        //Querying user details
        $query = "SELECT `rollno`, `password` FROM `student` WHERE `rollno` = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_SESSION['rollno']);
        $stmt->execute();
        $stmt->store_result();

        // If user exists
        if ($stmt->num_rows() == 0) {

            $stmt->close();

            $query = "SELECT `username`, `password` FROM `company` WHERE `username` = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $_SESSION['username']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows() == 0) {

                $stmt->close();

                $query = "SELECT `username`, `password` FROM `admin` WHERE `username` = ?";

                $stmt = $con->prepare($query);
                $stmt->bind_param('s', $_SESSION['username']);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows() == 0) {
                    $_SESSION['log_msg'] =  "ERROR: User does not exist.";
                    exit;
                } else {
                    $stmt->bind_result($username, $password);
                    $stmt->fetch();

                    if (md5($_POST["password"]) === $password) {


                        $updated_pass = $password;

                        if ($_POST['new_pass'] != "") {
                            if ($_POST['new_pass'] === $_POST['confirm_pass']) {
                                $updated_pass = md5($_POST['new_pass']);
                            } else {
                                $_SESSION['log_msg'] = "Password and Confirm Password fields are not matching!!!";
                                exit;
                            }
                        }

                        // Update user in database

                        $update_query = "UPDATE `admin`
                        SET `password` = '$updated_pass'
                        WHERE `username` = '$username'";

                        $result = mysqli_query($con, $update_query);

                        if ($result) {
                            // If update successful, also update session variables
                            $_SESSION['log_msg'] = "Password Changed Successfully";
                            header('Location: http://localhost/tpc_miniproj/admin');
                            exit;
                        } else {
                            $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
                        }
                    } else {
                        // Incorrect password
                        $_SESSION['log_msg'] =  'Incorrect password!';
                    }
                }
            } else {
                $stmt->bind_result($username, $password);
                $stmt->fetch();

                if (md5($_POST["password"]) === $password) {


                    $updated_pass = $password;

                    if ($_POST['new_pass'] != "") {
                        if ($_POST['new_pass'] === $_POST['confirm_pass']) {
                            $updated_pass = md5($_POST['new_pass']);
                        } else {
                            $_SESSION['log_msg'] = "Password and Confirm Password fields are not matching!!!";
                            exit;
                        }
                    }

                    // Update user in database

                    $update_query = "UPDATE `company`
                    SET `password` = '$updated_pass'
                    WHERE `username` = '$username'";

                    $result = mysqli_query($con, $update_query);

                    if ($result) {
                        // If update successful, also update session variables
                        $_SESSION['log_msg'] = "Password Changed Successfully";
                        header('Location: http://localhost/tpc_miniproj/company/profile_com.php');
                        exit;
                    } else {
                        $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
                    }
                } else {
                    // Incorrect password
                    $_SESSION['log_msg'] =  'Incorrect password!';
                }
            }
        } else {

            $stmt->bind_result($rollno, $password);
            $stmt->fetch();

            if (md5($_POST["password"]) === $password) {


                $updated_pass = $password;

                if ($_POST['new_pass'] != "") {
                    if ($_POST['new_pass'] === $_POST['confirm_pass']) {
                        $updated_pass = md5($_POST['new_pass']);
                    } else {
                        $_SESSION['log_msg'] = "Password and Confirm Password fields are not matching!!!";
                        exit;
                    }
                }

                // Update user in database

                $update_query = "UPDATE `student`
                SET `password` = '$updated_pass'
                WHERE `rollno` = '$rollno'";

                $result = mysqli_query($con, $update_query);

                if ($result) {
                    // If update successful, also update session variables
                    $_SESSION['log_msg'] = "Password Changed Successfully";
                    header('Location: http://localhost/tpc_miniproj/profile_stud.php');
                    // exit;
                } else {
                    $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
                    exit;
                }
            } else {
                // Incorrect password
                $_SESSION['log_msg'] =  'Incorrect password!';
                exit;
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
    <title>Change Password</title>
    <script>
        var check = function() {
            if (document.getElementById('new_pass').value ==
                document.getElementById('confirm_pass').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = '';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Password and Confirm Password fields are not matching!!!';
            }
        }
    </script>

    <style>
        h1 {
            text-align: center;
        }

        .form-center {
            display: flex;
            justify-content: center;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            border: 3px solid #fff;
            ;
        }

        .container {
            width: 100%;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="mvp.css" />
</head>

<body>

    <h1>Change Password</h1>

    <!-- Printing log message -->
    <div class="container">
    <span style="color:red;"><?= $log ?></span><br>
    </div>

    <div class="form-center">
    <form method="post" name="Edit Phone">
        <input placeholder="New Password" type="password" id="new_pass" name="new_pass" pattern=".{8,100}" title="Passwords should be 8 - 100 characters." onkeyup='check();' required size="30"/>
        <br>

        <input placeholder="Confirm Password" type="password" id="confirm_pass" name="confirm_pass" onkeyup='check();' required size="30"/>
        <br>

        <input placeholder="Password" type="password" id="password" name="password" pattern=".{8,100}" title="Passwords should be 8 - 100 characters." required size="30"/>
        <br>

        <div class="container">
        <span id='message'></span>
        </div>
        <br>

        <div class="center">
        <button type="submit">Submit</button>
        </div>
        <br>
    </form>
    </div>

    <br>

    <div class="container">
    <?php
    if (isset($_SESSION['utype'])) {
        if ($_SESSION['utype'] == "alumnus") {
            echo "<a href='http://localhost/tpc_miniproj/profile_stud.php'>Back to Profile</a><br><br>";
            echo "<a href='http://localhost/tpc_miniproj/alumni/index.php'>Back to Home</a>";
        } else if ($_SESSION['utype'] == 'student') {
            echo "<a href='http://localhost/tpc_miniproj/profile_stud.php'>Back to Profile</a><br><br>";
            echo "<a href='http://localhost/tpc_miniproj/student/index.php'>Back to Home</a>";
        } else if ($_SESSION['utype'] == 'company') {
            echo "<a href='http://localhost/tpc_miniproj/company/profile_com.php'>Back to Profile</a><br><br>";
            echo "<a href='http://localhost/tpc_miniproj/company/index.php'>Back to Home</a>";
        }
    }
    ?>
    </div>
</body>

</html>