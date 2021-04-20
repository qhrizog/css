<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "n_user";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if (!$conn){
        die('Unable to access the database');
        exit;
    }
?>