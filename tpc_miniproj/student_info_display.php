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
    <title>Student Information</title>
    <style>
    h1 {text-align: center;}
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
        min-width: 900px;
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
    <h1>Student Information</h1>
    <br>

    <div class="center">
    <table class="content-table">
        <thead> 
        <tr>
            <th>Name</th>
            <th>Roll No.</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Branch</th>
            <th>CPI</th>
            <th>Grade 10 Marks</th>
            <th>Grade 12 Marks</th>
            <th>Resume</th>
            <th>Transcript</th>
        </tr>
        </thead>
        <?php
            // Connect to the database
            $conn = mysqli_connect("localhost", "root", "", "tpc_miniproj");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve data from the table
            $sql = "SELECT `first_name`, `middle_name`, `last_name`, `rollno`, `email`, `phone`, `branch`, `cpi`, `grade10`, `grade12` FROM `student`";

            if (isset($_GET["filter"])) {
            $branch = $_GET["branch"];
            $cpi = $_GET["cpi"];

            $conditions = array();

            if (!empty($branch)) {
                $conditions[] = "`branch` = '$branch'";
            }
            if (!empty($cpi)) {
                $conditions[] = "`cpi` = '$cpi'";
            }

            if (count($conditions) > 0) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }
            }

            $result = $conn->query($sql);


            // Display the data in the table
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $file_link1 = '<a href="/tpc_miniproj/resume/' . $row["rollno"] . '_resume.pdf"  target="_blank">View Resume</a>';
                    $file_link2 = '<a href="/tpc_miniproj/resume/' . $row["rollno"] . '_transcript.pdf"  target="_blank">View Transcript</a>';
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>".$row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]."</td>";
                    echo "<td>".$row["rollno"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["phone"]."</td>";
                    echo "<td>".$row["branch"]."</td>";
                    echo "<td>".$row["cpi"]."</td>";
                    echo "<td>".$row["grade10"]."</td>";
                    echo "<td>".$row["grade12"]."</td>";
                    echo "<td>".$file_link1."</td>";
                    echo "<td>".$file_link2."</td>";
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
    <br>
    
    <div class="form-center">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <label for="branch">branch:</label>
        <input type="text" name="branch" placeholder="branch">

        <label for="cpi">CPI:</label>
        <input type="text" name="cpi" placeholder="CPI">

        <div class="container">
        <input type="submit" name="filter" value="Filter">
        </div>
    </form>
    </div>
    <br>

    <div class="container">
    <a href="company/index.php"><button>Home</button></a>
    </div>

</body>
</html>