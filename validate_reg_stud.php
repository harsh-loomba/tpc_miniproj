<?php

//Start session
session_start();

//include connection.php
include_once('connection.php');

//Connect to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /*
    $_POST ->
        rollno*
        course*
        grad_yr*
        alumni*
        email*
        first_name*
        mid_name
        last_name
        phone*
        password*
        confirm_pass*
    */

    /*
    MySQL->
        rollno*
        email*
        password*
        first_name*
        middle_name
        last_name
        phone*
        course*
        branch*
        grad_yr*
        is_alumnus*
    */

    //If all parameters present in post
    if (!isset(
        $_POST["rollno"],
        $_POST["course"],
        $_POST["grad_yr"],
        $_POST["email"],
        $_POST["first_name"],
        $_POST["phone"],
        $_POST["password"],
        $_POST["confirm_pass"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {
        $rollno = convert_input($_POST["rollno"]);

        $email = convert_input($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $password = md5(convert_input($_POST["password"]));
        $confirm_pass = md5(convert_input($_POST["confirm_pass"]));

        $first_name = convert_input($_POST["first_name"]);
        $middle_name = convert_input($_POST["mid_name"]);
        $last_name = convert_input($_POST["last_name"]);

        $phone = convert_input($_POST["phone"]);
        $course = convert_input($_POST["course"]);
        $branch = strtoupper(substr($rollno, 4, 2));

        $grad_yr = (int)filter_var($_POST["grad_yr"], FILTER_SANITIZE_NUMBER_INT);

        $is_alumnus = 0;
        if (isset($_POST["alumni"]) && (convert_input($_POST["alumni"]) == "true")) {
            $is_alumnus = 1;
        }

        //reconfirming passed data
        if ($password === $confirm_pass) {

            $dupli_query = "SELECT DISTINCT `rollno` FROM `student` WHERE `rollno` = '$rollno'";

            $dupli_chk = mysqli_query($con, $dupli_query);

            //User exits?
            if (mysqli_num_rows($dupli_chk) > 0) {
                $_SESSION['log_msg'] = "User already exists!";
            } else {
                //Registering

                $query =
                    "INSERT INTO `student`
                    (`rollno`,`email`, `password`, 
                    `first_name`, `middle_name`, `last_name`, 
                    `phone`, 
                    `course`, `branch`, `grad_yr`, `is_alumnus`,`grade10`, `grade12`, `CPI`)
                VALUES (
                    '$rollno', '$email', '$password', 
                    '$first_name', '$middle_name', '$last_name',
                    '$phone',
                    '$course', '$branch', '$grad_yr', '$is_alumnus',
                    NULL, NULL, NULL
                );";

                $result = mysqli_query($con, $query);

                if ($result) {
                    $_SESSION['log_msg'] = "Registered Successfully!";
                    header('Location: http://localhost/tpc_miniproj/index.php');
                    exit();
                } else {
                    $_SESSION['log_msg'] = "Server Error : User not registered.";
                }
            }
        } else {
            $_SESSION['log_msg'] = "Password and Confirm Password field are not matching!!!";
        }
    }
}
//Redirectiong to register page if user not regitered
header('Location: register_stud.php');
