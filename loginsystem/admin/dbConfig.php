<?php
// Database configuration
$dbHost     = "localhost:8080;
$dbUsername = "actwebsp_39";
$dbPassword = "Hello@123";
$dbName     = "edgelink_db";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>