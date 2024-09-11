<?php
// Database connection
$servername = "localhost";
$username = "root"; // use your DB username
$password = "";     // use your DB password
$dbname = "edgelink_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update query
    $sql = "UPDATE about_us SET title='$title', description='$description' WHERE id=1"; // Assuming you update the first entry

    if ($conn->query($sql) === TRUE) {
        echo "About Us updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
