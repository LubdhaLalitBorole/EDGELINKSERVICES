<?php

$conn = mysqli_connect('localhost', 'root', '', 'edgelink_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // This will output the error if the connection fails
}

?>
