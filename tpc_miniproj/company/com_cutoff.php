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
        $_POST["course"],
        $_POST["branch"],
        $_POST["cutoff"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {
        $course = convert_input($_POST["course"]);
        $branch = convert_input($_POST["branch"]);
        $cutoff = $_POST['cutoff'];
        $username = $_SESSION['username'];

        $dupli_query =
            "SELECT `username`,`course`, `branch`, `cutoff`
            FROM `company_cutoff`
            WHERE `username` = ?
            AND `course` = '$course'
            AND `branch` = '$branch';";

        $stmt = $con->prepare($dupli_query);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $stmt->store_result();

        $query =
            "INSERT INTO `company_cutoff`
            (`username`,`course`, `branch`, `cutoff`)
            VALUES ('$username', '$course', '$branch', '$cutoff');";

        if ($stmt->num_rows() > 0) {
            $query =
                "UPDATE `company_cutoff`
                SET `cutoff` = '$cutoff'
                WHERE `username` = '$username'
                AND `course` = '$course'
                AND `branch` = '$branch';";
        }

        $result = mysqli_query($con, $query);

        if ($result) {
            if ($stmt->num_rows() == 0) {
                $_SESSION['log_msg'] = "Eligibility Criteria Added!";
            } else {
                $_SESSION['log_msg'] = "Eligibility Criteria Updated!";
            }
        } else {
            $_SESSION['log_msg'] = "Server Error : Criteria not added / updated.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Cutoff</title>
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

            <h1>Set Eligibility Criteria</h1>

            <!-- Printing log message -->
            <div class="container">
            <span style="color:red;"><?= $log ?></span>
            </div>
            <br>

            Course:
            <select id="course" name="course" required>
                <label for="course">
                    Course
                </label>

                <option value="B.Tech. / B.S.">B.Tech. / B.S.</option>
                <option value="M.Tech.">M.Tech.</option>
                <option value="Ph.D.">Ph.D.</option>
            </select>
            <br>
            Branch:
            <select id="branch" name="branch" required>
                <label for="branch">
                    Branch
                </label>
                <option selected=true disabled=true>Select Branch</option>
                <option value="AI">Artificial Intelligence and Data Science</option>
                <option value="CB">Chemical Engineering</option>
                <option value="CE">Civil and Environmental Engineering</option>
                <option value="CS">Computer Science and Engineering</option>
                <option value="EE">Electrical and Electronics Engineering</option>
                <option value="MC">Mathematics and Computing</option>
                <option value="ME">Mechanical Engineering</option>
                <option value="MM">Materials and Metallurgical Engineering</option>
                <option value="PH">Engineering Physics</option>

            </select>
            <br>

            Cutoff CPI: <input placeholder="cutoff" name="cutoff" type="number" min=0 max=10 step=0.01 required>
            <br>

            <div class="center">
            <button type="submit">Add / Update Criteria</button>
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