<?php
session_start();

//Including connection
include_once('connection.php');

//Connecting to database
$con = getDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Information</title>
    <style>
    h1 {text-align: center;}
    h3 {text-align: center;}
    .form-center {
    display:flex;
    justify-content: center;
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
    <link rel="stylesheet" type="text/css" href="mvp.css" />
</head>

<style>
    .content-table
    {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .content-table thead tr
    {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }

    .content-table th,
    .content-table td
    {
        padding: 12px 15px;
    }

    .content-table tbody tr
    {
        border-bottom: 1px solid #dddddd;
    }

    .content-table tbody tr:nth-of-type(even)
    {
        background-color: #f3f3f3;
    }

    .content-table tbody tr:last-of-type
    {
        border-bottom: 2px solid #009879;
    }

    .content-table tbody tr.active-row
    {
            font-weight: bold;
        color: #009879;
    }
</style>

<body>
    <h1>Company Information</h1>

    <div class="center">
    <table class="content-table">
        <thead> 
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>Cutoff</th>
            <th>Field</th>
            <th>Position</th>
            <th>Package</th>
            <th>Interview</th>
        </tr>
        </thead>
        <?php
            // Connect to the database
            $conn = mysqli_connect("localhost", "root", "", "tpc_miniproj");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve data from the table
            $sql = "SELECT `com_name`, `email`, `cutoff`, `field`, `position`, `package` FROM `company` NATURAL JOIN `company_cutoff` NATURAL JOIN `company_job` WHERE `branch` = '{$_SESSION['branch']}'";
            $result = $conn->query($sql);

            // Display the data in the table
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>".$row["com_name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["cutoff"]."</td>";
                    echo "<td>".$row["field"]."</td>";
                    echo "<td>".$row["position"]."</td>";
                    echo "<td>".$row["package"]."</td>";
                    echo "<td><a href='interview_details.php?com_name=".$row["com_name"]."&position=".$row["position"]."&field=".$row["field"]."'>Details</a></td>";
                    echo "</tr>";
                    echo "</tbody>";
                }
            } else {
                echo "<tbody>";
                echo "<tr>";
                echo "<td colspan='8'>No Companies Available</td>";
                echo "</tr>";
                echo "</tbody>";
            }
            $conn->close();
        ?>
    </table>
    </div>
    <div class="center">
    <a href="student/index.php"><button>Home</button></a>
    </div>

</body>
</html>