<?php

define('HOST', 'localhost');
define('DATABASE', 'tpc_miniproj');

//function to connect to a database
function getDB()
{
    define('USER', 'root');
    define('PASSWORD', '');

    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: $conn -> connect_error \n");
    }

    return $conn;
}

//function to connect to a database
function getDB_spl($user, $password)
{
    $conn = new mysqli(HOST, $user, $password, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: $conn -> connect_error \n");
    }

    return $conn;
}

//function to format input data to remove whitespace / slashes / special characters
function convert_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
