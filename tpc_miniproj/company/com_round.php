<?php

//starting session
session_start();

//display any error / log messages
$log = '';

//include connection.php
include_once('../connection.php');

//Connect to database
$con = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //If all parameters present in post
    if (!isset(
        $_POST["round"],
        $_POST["mode"],
        $_POST["type"]
    )) {
        $_SESSION['log_msg'] = "Please fill all the required fields.";
    } else {
        $round = $_POST["round"];
        $mode = $_POST["mode"];
        $type = $_POST['type'];
        $username = $_SESSION['username'];

        $dupli_query =
            "SELECT `username`,`round`, `mode`, `type`
            FROM `company_interview`
            WHERE `username` = ?
            AND `round` = '$round';";

        $stmt = $con->prepare($dupli_query);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $stmt->store_result();

        $query =
            "INSERT INTO `company_interview`
            (`username`,`round`, `mode`, `type`)
            VALUES ('$username', '$round', '$mode', '$type');";

        if ($stmt->num_rows() > 0) {
            $query =
                "UPDATE `company_interview`
                SET `mode` = '$mode',
                `type` = '$type'
                WHERE `username` = '$username'
                AND `round` = '$round';";
        }

        $result = mysqli_query($con, $query);

        if ($result) {
            if ($stmt->num_rows() == 0) {
                $_SESSION['log_msg'] = "Round $round Added!";
            } else {
                $_SESSION['log_msg'] = "Round $round Updated!";
            }
        } else {
            $_SESSION['log_msg'] = "Server Error : Criteria not added / updated.";
        }

        $stmt->close();
    }
}

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
    <title>Set Cutoff</title>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
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

        .container {
            width: 100%;
            text-align: center;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            border: 3px solid #fff;
            ;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="../mvp.css" />
</head>

<body>
    <br>
    <div class="session">

        <h1>Placement Round Details</h1>
        <br><br>

        <div class="center">
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Round</th>
                        <th>Mode</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <?php
                // Connect to the database
                $conn = mysqli_connect("localhost", "root", "", "tpc_miniproj");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve data from the table
                $uname = $_SESSION['username'];
                $sql = "SELECT `round`, `mode`, `type` FROM `company_interview` WHERE `username` = '$uname'";

                $result = $conn->query($sql);


                // Display the data in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td>" . $row["round"] . "</td>";
                        echo "<td>" . $row["mode"] . "</td>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                } else {
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td colspan='8'>No Data Available</td>";
                    echo "</tr>";
                    echo "</tbody>";
                }
                $conn->close();
                ?>
            </table>
        </div>
        <br><br><br>




        <!-- Register form -->
        <div class="form-center">
            <form method="post" action="" name="add_job">

                <!-- Printing log message -->
                <div class="container">
                    <span style="color:red;"><?= $log ?></span>
                </div>
                <br>

                Round No.: <input placeholder="Round" name="round" type="number" min=1 step=1 value=1 required>
                <br>

                Mode of Conduction:
                <select id="mode" name="mode" required>
                    <label for="mode">
                        Mode
                    </label>

                    <option selected=true disabled=true>Select</option>

                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
                <br>

                Round Type:
                <select id="type" name="type" required>
                    <label for="mode">
                        Type
                    </label>

                    <option selected=true disabled=true>Select</option>

                    <option value="Written">Written</option>
                    <option value="Coding">Coding</option>
                    <option value="Interview">Interview</option>
                </select>
                <br>

                <div class="center">
                    <button type="submit">Add / Update Round</button>
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