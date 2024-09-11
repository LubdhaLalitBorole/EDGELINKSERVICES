<?php 
session_start();

if (empty($_SESSION['ad_id'])) {
    header('location:login.php');
    exit(); // Stop further execution after redirect
}

// Include your database connection file if not already included
include 'conn.php'; // Ensure the database connection is properly included

$ad_id = $_SESSION['ad_id'];

// Execute the query and check for errors
$query = "SELECT * FROM admin WHERE ad_id = '$ad_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    // If the query fails, output the error and stop execution
    die("Database query failed: " . mysqli_error($con));
}

// Fetch the user data if the query was successful
$row = mysqli_fetch_array($result);

if ($row) {
    $user_role = $row['ad_id'];
    $user_email = $row['ad_email'];
    $user_name = $row['ad_name'];
} else {
    echo "No user found with the given ID.";
}
?>
