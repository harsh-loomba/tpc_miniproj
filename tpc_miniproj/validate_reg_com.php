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
        com_name
        uname
        email
        password
        confirm_pass
    */

    /*
    MySQL->
        username
        email
        password
        com_name
        rep_name
        phone
        recruit_yr
    */

    //If all parameters present in post
    if (!isset(
        $_POST["com_name"],
        $_POST["uname"],
        $_POST["email"],
        $_POST["password"],
        $_POST["confirm_pass"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {
        $com_name = convert_input($_POST["com_name"]);
        $username = convert_input($_POST["uname"]);

        $email = convert_input($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $password = md5(convert_input($_POST["password"]));
        $confirm_pass = md5(convert_input($_POST["confirm_pass"]));

        //reconfirming passed data
        if ($password === $confirm_pass) {

            $dupli_query = "SELECT DISTINCT `username` FROM `company` WHERE `username` = '$username'";

            $dupli_chk = mysqli_query($con, $dupli_query);

            //User exits?
            if (mysqli_num_rows($dupli_chk) > 0) {
                $_SESSION['log_msg'] = "Username taken!";
            } else {
                //Registering

                $query =
                    "INSERT INTO `company`
                    (`username`,`email`, `password`, 
                    `com_name`, `rep_name`,
                    `phone`, `recruit_yr`)
                VALUES (
                    '$username', '$email', '$password', 
                    '$com_name', NULL, 
                    NULL, NULL
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
header('Location: register_com.php');
