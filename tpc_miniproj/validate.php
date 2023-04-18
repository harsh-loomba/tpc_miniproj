<?php

//start session
session_start();

//include connection.php
include_once('connection.php');

//connect to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //error for insufficient details
    if (!isset($_POST["uname"], $_POST["password"])) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {

        //Finding user in database
        $query =
            "SELECT
            `rollno`, `email`, `password`,
            `first_name`, `middle_name`, `last_name`,
            `phone`,
            `course`, `branch`, `grad_yr`, `is_alumnus`,
            `grade10`, `grade12`, `CPI`
            FROM `student` WHERE `rollno` = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_POST['uname']);
        $stmt->execute();
        $stmt->store_result();

        //If no rows returned
        if ($stmt->num_rows() == 0) {

            $stmt->close();

            $query = "SELECT
            `username`,`email`, `password`, 
            `com_name`, `rep_name`,
            `phone`, `recruit_yr`
            FROM `company` WHERE `username` = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $_POST['uname']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows() == 0) {
                $_SESSION['log_msg'] = "User does not exist!";
                header('Location: http://localhost/tpc_miniproj/index.php');
            } else {
                $stmt->bind_result(
                    $username,
                    $email,
                    $password,
                    $com_name,
                    $rep_name,
                    $phone,
                    $recruit_yr
                );

                $stmt->fetch();

                if (md5($_POST["password"]) === $password) {

                    //Login session

                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    $_SESSION['com_name'] = $com_name;
                    $_SESSION['rep_name'] = $rep_name;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['recruit_yr'] = $recruit_yr;
                    $_SESSION["utype"] = "company";


                    $_SESSION['log_msg'] = 'Logged In!';

                    header('Location: http://localhost/tpc_miniproj/company/');
                    exit;
                } else {
                    // Incorrect password
                    $_SESSION['log_msg'] = 'Incorrect username and/or password!';
                }
            }
        } else {
            //User exits
            $stmt->bind_result(
                $rollno,
                $email,
                $password,
                $first_name,
                $middle_name,
                $last_name,
                $phone,
                $course,
                $branch,
                $grad_yr,
                $is_alumnus,
                $grade10,
                $grade12,
                $CPI
            );
            $stmt->fetch();

            //Check password
            if (md5($_POST["password"]) === $password) {

                //Login session

                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['rollno'] = $rollno;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['middle_name'] = $middle_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['phone'] = $phone;
                $_SESSION['course'] = $course;
                $_SESSION['branch'] = $branch;
                $_SESSION['grad_yr'] = $grad_yr;
                $_SESSION['alumnus'] = $is_alumnus;
                $_SESSION['grade10'] = $grade10;
                $_SESSION['grade12'] = $grade12;
                $_SESSION['CPI'] = $CPI;

                $_SESSION['log_msg'] = 'Logged In!';

                if ($_SESSION['alumnus'] === 1) {
                    $_SESSION["utype"] = "alumni";
                    header('Location: http://localhost/tpc_miniproj/alumni/');
                    exit;
                } else {
                    $_SESSION["utype"] = "student";
                    header('Location: http://localhost/tpc_miniproj/student/');
                    exit;
                }
            } else {
                // Incorrect password
                $_SESSION['log_msg'] = 'Incorrect username and/or password!';
            }
        }

        $stmt->close();
    }
}

//Head back to index if not logged in

header('Location: http://localhost/tpc_miniproj/index.php');
