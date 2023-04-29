<?php

//starting session
session_start();

//if logged in, redirect to home page
if (isset($_SESSION['loggedin'], $_SESSION['utype'])) {
    if ($_SESSION['loggedin'] == true) {

        if ($_SESSION['utype'] === 'student') {

            header('Location: http://localhost/tpc_miniproj/student/index.php');
        } else if ($_SESSION['utype'] === 'alumni') {

            header('Location: http://localhost/tpc_miniproj/alumni/index.php');
        }
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
                PH: "Engineering Physics"
            };
            var text = data[document.getElementById('rollno').value.substr(4, 2)];
            if (text == undefined) {
                text = '';
            }
            document.getElementById('branch').innerHTML = text;
        }
    </script>

    <link rel="stylesheet" type="text/css" href="mvp.css" />

</head>

<body>
    <br>
    <div class="session">

        <!-- Register form -->
        <div class="form-center">
            <form method="post" action="validate_reg_stud.php" name="Register">

                <h1>Register</h1>

                <!-- Printing log message -->
                <div class="container">
                    <span style="color:red;"><?= $log ?></span><br>
                </div>
                <br>

                <input placeholder="IITP Roll No." type="text" id="rollno" name="rollno" pattern="\d\d\d\d[A-Za-z][A-Za-z][0-9]+" title="Invalid roll number." onkeyup="get_branch()" required size="30" />

                <select id="course" name="course" required>
                    <label for="course">
                        Course Enrolled
                    </label>

                    <option value="B.Tech.">B.Tech.</option>
                    <option value="B.S.">B.S.</option>
                    <option value="M.Tech.">M.Tech.</option>
                    <option value="Ph.D.">Ph.D.</option>
                </select>

                Branch : <span id="branch"></span>
                <br>
                <br>

                Graduation Year: <input id="grad_yr" name="grad_yr" type="number" min="2008" max="2099" step="1" required />

                Alumni: <input type="checkbox" id="alumni" name="alumni" value="true">
                <br>

                <input placeholder="IITP Webmail" type="email" name="email" pattern="[A-Za-z]+_\d\d\d\d[A-Za-z][A-Za-z][0-9]+@iitp\.ac\.in" title="Invalid IITP webmail address." required size="30" />

                <input placeholder="First Name" type="text" name="first_name" pattern="^[a-zA-Z][a-zA-Z\s]*$" title="Names cannot contain digits or special characters." required size="30" />

                <input placeholder="Middle Name" type="text" name="mid_name" pattern="^[a-zA-Z][a-zA-Z\s]*$" title="Names cannot contain digits or special characters." size="30" />

                <input placeholder="Last Name" type="text" name="last_name" pattern="^[a-zA-Z][a-zA-Z\s]*$" title="Names cannot contain digits or special characters." size="30" />

                <input placeholder="Phone No." name="phone" type="text" title="10-digit Phone No." pattern="\d\d\d\d\d\d\d\d\d\d" required size="30">

                <input placeholder="Password" type="password" id="password" name="password" pattern=".{8,100}" title="Passwords should be 8 - 100 characters." onkeyup='check();' required size="30" />

                <input placeholder="Confirm Password" type="password" id="confirm_pass" name="confirm_pass" onkeyup='check();' required size="30" />

                <span id='message'></span>

                <div class="center">
                    <button type="submit">Register</button>
                </div>

                <div class="container">
                    <a href="index.php">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>