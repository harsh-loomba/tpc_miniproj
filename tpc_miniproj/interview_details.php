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
    <title>Interview Details</title>
    <style>
    h1 {text-align: center;}
    h2 {text-align: center;}
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
    <?php
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "tpc_miniproj");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve interview details from the table
        $com_name = $_GET['com_name'];
        $position = $_GET['position'];
        $field = $_GET['field'];
    ?>

    <h1>Interview Details</h1>
    <br>
    <h2><?php echo "{$com_name}"; ?></h3>

    <div class="center">
    <table class="content-table" style="margin-left:auto; margin-right:auto;">
        <thead> 
        <tr>
            <th>Position</th>
            <th>Field</th>
            <th>Round</th>
            <th>Mode</th>
            <th>Type</th>
        </tr>
        </thead>
        <?php
            $sql = "SELECT `round`, `mode`, `type` FROM `company` NATURAL JOIN `company_interview` NATURAL JOIN `company_job` WHERE `com_name` = '{$com_name}' AND `position` = '{$position}' AND `field` = '{$field}'";
            $result = $conn->query($sql);

            // Display the interview details in the table
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>{$position}</td>";
                    echo "<td>{$field}</td>";
                    echo "<td>".$row["round"]."</td>";
                    echo "<td>".$row["mode"]."</td>";
                    echo "<td>".$row["type"]."</td>";
                    echo "</tr>";
                    echo "</tbody>";
                }
            } else {
                echo "<tbody>";
                echo "<tr>";
                echo "<td colspan='9' style='text-align:center'>No Interview Details Available</td>";
                echo "</tr>";
                echo "</tbody>";
            }
            // Close the database connection
            mysqli_close($conn);
        ?>
    </table>
    </div>
    <div class="center">
    <a href="company_info_display.php"><button>Back to Company Data</button></a>
    </div>
                    
</body>
</html>
