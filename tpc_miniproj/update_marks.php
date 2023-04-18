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

// (string) $_SESSION['log_msg'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Checkign if all parameters passed
    if (!isset($_POST["grade10"], $_POST["grade12"], $_POST["CPI"])) {
        // $_SESSION['log_msg'] = "Please fill all the required fields. Names cannot be empty strings";
    } else if ($_POST["grade10"] != $_SESSION["grade10"] || $_POST["grade12"] != $_SESSION["grade12"] || $_POST["CPI"] != $_SESSION["CPI"]) {

        //Querying user details
        $query = "SELECT `rollno` FROM `student` WHERE `rollno` = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_SESSION['rollno']);
        $stmt->execute();
        $stmt->store_result();

        // If user exists
        if ($stmt->num_rows() == 0) {
            $_SESSION['log_msg'] =  "ERROR: User does not exist.";
        } else {

            $stmt->bind_result($rollno);
            $stmt->fetch();


            $grade10 = $_POST['grade10'];
            $grade12 = $_POST['grade12'];
            $CPI = $_POST['CPI'];

            // Check that grades are float values
            if (!is_numeric($grade10) || !is_numeric($grade12) || !is_numeric($CPI)) {
                $_SESSION['log_msg'] = "Error: grades must be numeric values.";
            } else {

                // Update user in database

                $update_query = "UPDATE `student`
                    SET `grade10` = '$grade10', `grade12` = '$grade12', `CPI` = '$CPI'
                    WHERE `rollno` = '$rollno'";

                $result = mysqli_query($con, $update_query);

                if ($result) {
                    // If update successful, also update session variables
                    $_SESSION['log_msg'] = "Marks details Updated Successfully";
                    $_SESSION['grade10'] = $grade10;
                    $_SESSION['grade12'] = $grade12;
                    $_SESSION['CPI'] = $CPI;
                } else {
                    $_SESSION['log_msg'] = "Unexpected error: Details not changed.";
                }
            }
        }

        $stmt->close();
    }
}




if (isset($_POST['submit'])) {

    $folder_path = 'C:/xampp/htdocs/tpc_miniproj/resume/';

    $filename = basename($_FILES['resume']['name']);
    $newname = $folder_path . $filename;

    $query = "SELECT `rollno` FROM `student` WHERE `rollno` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $_SESSION['rollno']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows() == 0) {
        $_SESSION['log_msg'] =  "ERROR: User does not exist.";
    } else {
        $stmt->bind_result($rollno);
        $stmt->fetch();
        $testing = "_resume.pdf";
        $finame = $rollno . $testing;
        $newname = $folder_path . $finame;

        // Check file size limit
        if ($_FILES['resume']['size'] > 2000000) {
            $_SESSION['log_msg'] = " File size exceeds limit of 2MB.";
        }
        // Check file type
        else if ($_FILES['resume']['type'] == "application/pdf") {
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $newname)) {

                $_SESSION['log_msg'] = " Resume Upload Successful.";

                $file_link = '<a href="/tpc_miniproj/resume/' . $finame . '">View Resume</a>';
                //$filesql =  "UPDATE `student` SET `resume` = '$filename' WHERE `rollno` = '$rollno'";
                //$fileresult = mysqli_query($con, $filesql);
            } else {
                $_SESSION['log_msg'] = " Resume Upload Failed.";
            }

            if (isset($file_link)) {
                echo $file_link;
            }

            // if (isset($fileresult)) {
            //     echo 'Success';
            // } else {
            //     echo 'fail';
            // }
        } else {
            $_SESSION['log_msg'] = " Resume Must be uploaded in PDF format.";
        }

        $stmt->close();
    }
}




if (isset($_POST['tsubmit'])) {

    $folder_path = 'C:/xampp/htdocs/tpc_miniproj/transcript/';

    $filename = basename($_FILES['transcript']['name']);
    $newname = $folder_path . $filename;

    $query = "SELECT `rollno` FROM `student` WHERE `rollno` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $_SESSION['rollno']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows() == 0) {
        $_SESSION['log_msg'] =  "ERROR: User does not exist.";
    } else {
        $stmt->bind_result($rollno);
        $stmt->fetch();
        $testing = "_transcript.pdf";
        $finame = $rollno . $testing;
        $newname = $folder_path . $finame;

        if ($_FILES['transcript']['size'] > 1000000) {
            $_SESSION['log_msg'] = " File size exceeds limit of 1MB.";
        } else if ($_FILES['transcript']['type'] == "application/pdf") {
            if (move_uploaded_file($_FILES['transcript']['tmp_name'], $newname)) {

                $_SESSION['log_msg'] = " Transcript Upload Successful.";
                $file_link = '<a href="/tpc_miniproj/transcript/' . $finame . '">View Transcript</a>';

                //$filesql =  "UPDATE `student` SET `resume` = '$filename' WHERE `rollno` = '$rollno'";
                //$fileresult = mysqli_query($con, $filesql);
            } else {

                $_SESSION['log_msg'] = " Tanscript Upload Failed.</p>";
            }

            if (isset($file_link)) {
                echo $file_link;
            }

            // if (isset($fileresult))
            // {
            //     echo 'Success';
            // } else
            // {
            //     echo 'fail';
            // }
        } else {
            $_SESSION['log_msg'] = " Must be uploaded in PDF format. ";
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

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</head>

<body>

    <h4>Update Marks</h4>

    <!-- Printing log message -->
    <span style="color:red;"><?= $log ?></span><br>

    <form method="post" name="Update Marks">

        Grade 10: <input placeholder="Grade 10" name="grade10" type="number" min=0 max=100 step=0.01 required value="<?= $_SESSION['grade10'] ?>"><br>
        Grade 12: <input placeholder="Grade 12" name="grade12" type="number" min=0 max=100 step=0.01 required value="<?= $_SESSION['grade12'] ?>"><br>
        CPI: <input placeholder="CPI" name="CPI" type="number" min=0 max=10 step=0.01 required value="<?= $_SESSION['CPI'] ?>"><br>

        <button type="submit">Save</button>
        <br>
    </form>

    <br>
    <br>

    <h4>Upload Files</h4>

    <br>
    <form action="" method="post" enctype="multipart/form-data">

        <label>Upload Resume</label>
        <span class="btn btn-default btn-file">
            <input name="resume" type="file">
        </span>
        <br /><br />
        <input type="submit" name="submit" class="btn-success" value="submit">
    </form>
    </form>

    <form action="" method="post" enctype="multipart/form-data">

        <label>Upload Transcript</label>
        <span class="btn btn-default btn-file">
            <input name="transcript" type="file">
        </span>
        <br /><br />
        <input type="submit" name="tsubmit" class="btn-success" value="submit">
    </form>
    </form>

    <span id='message'></span>
    <br>

    <a href='http://localhost/tpc_miniproj/change_password.php/'>Change Password</a>
    <br>

    <?php
    if ($_SESSION['alumnus']) {
        echo "<a href='http://localhost/tpc_miniproj/alumni/index.php'>Back to Home</a>";
    } else {
        echo "<a href='http://localhost/tpc_miniproj/student/index.php'>Back to Home</a>";
    }
    ?>


</body>

</html>