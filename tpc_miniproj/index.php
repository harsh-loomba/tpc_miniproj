<?php

//starting session
session_start();

//if logged in, redirect to home page
// if (isset($_SESSION['loggedin'])) {
//     if ($_SESSION['loggedin'] == true) {
//         header('Location: home.php');
//     }
//     exit;
// }

//display any error / log messages
$log = '';

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
    <title>Login</title>
    <script>
        // function ModifyPlaceHolder(element) {
        //     var data = {
        //         student: "IITP Roll No.",
        //         alumni: "IITP Roll No.",
        //         admin: "Username",
        //         company: "Username"
        //     };
        //     var input = element.form.uname;
        //     input.placeholder = data[element.id];
        // }
    </script>
    <style>
        .form-center {
            display:flex;
            justify-content:center;
        }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            border: 3px solid #fff;;
        }
        .container{
            width: 100%;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="mvp.css"/>
</head>

<body>

    <!-- Login form -->
    <br>
    <div class="form-center">
    <form method="post" action="validate.php" name="Login">

        <!-- Printing log message -->
        <div class="container">
        <span style="color:red;"><?= $log ?></span>
        </div>
        <br>

        <input placeholder="Username" type="text" id="uname" name="uname" title="Invalid username." required />
        <br>

        <input placeholder="Password" type="password" name="password" pattern=".{8,100}" title="Passwords should be 8 - 100 characters." required />
        <br>

        <!-- <label for="student">
            <input type="radio" name="utype" onclick="ModifyPlaceHolder(this)" id="student" value="Student" checked="checked">
            Student
        </label>

        <label for="company">
            <input type="radio" name="utype" onclick="ModifyPlaceHolder(this)" id="company" value="Company">
            Company
        </label>

        <label for="alumni">
            <input type="radio" name="utype" onclick="ModifyPlaceHolder(this)" id="alumni" value="Alumni">
            Alumni
        </label>

        <label for="admin">
            <input type="radio" name="utype" onclick="ModifyPlaceHolder(this)" id="admin" value="Company">
            Admin
        </label>
        <br> -->

        <div class="center">
        <button type="submit" value="Login">Login</button>
        </div>
        <br>

        <div class="container">
        <a href="register_stud.php">Register as Student / Alumni</a>
        </div>
        <br>

        <div class="container">
        <a href="register_com.php">Register as Company</a>
        </div>
        <br>

    </form>
    </div>

</body>

</html>