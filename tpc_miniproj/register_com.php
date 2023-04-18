<?php

//starting session
session_start();

//if logged in, redirect to home page
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin'] == true) {
        header('Location: home.php');
    }
    exit;
}

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
    <title>Register</title>

    <style>
        h1 {text-align: center;}
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

    <script>
        // Javascript function to check frontend password matching
        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('confirm_pass').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = '';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Password and Confirm Password fields are not matching!!!';
            }
        }
    </script>
    <link rel="stylesheet" type="text/css" href="mvp.css"/>
</head>

<body>
    <br>
    <div class="session">

        <!-- Register form -->
        <div class="form-center">
        <form method="post" action="validate_reg_com.php" name="Register" class="log-in">

            <h1>Register</h1>
            <br>

            <!-- Printing log message -->
            <div class="container">
            <span style="color:red;"><?= $log ?></span>
            </div>

            <input placeholder="Company Name" type="text" pattern=".{0,256}" name="com_name" required />
            <br>

            <input placeholder="Username" type="text" name="uname" pattern=".{0,100}" title="Username should be between 8 to 100 characters." required />
            <br>

            <input placeholder="Email" type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email address." required />
            <br>

            <input placeholder="Password" type="password" id="password" name="password" pattern=".{8,100}" title="Passwords should be between 8 to 100 characters." onkeyup='check();' required />
            <br>

            <input placeholder="Confirm Password" type="password" id="confirm_pass" name="confirm_pass" onkeyup='check();' required />
            <br>

            <span id='message'></span>
            <br>

            <div class="center">
            <button type="submit">Register</button>
            </div>
            <br>

            <div class="container">
            <a href="index.php">Back to login</a>
            </div>
        </form>
        </div>
    </div>
</body>

</html>