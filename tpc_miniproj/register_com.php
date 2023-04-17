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

</head>

<body>
    <div class="session">


        <!-- Register form -->

        <form method="post" action="validate_reg_com.php" name="Register" class="log-in">

            <h4>Register</h4>

            <!-- Printing log message -->
            <span style="color:red;"><?= $log ?></span>


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

            <button type="submit">Register</button>
            <br>

            <a href="index.php">Back to login</a>
    </div>
</body>

</html>