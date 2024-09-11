<?php
$conn = new mysqli('localhost', 'root', '', 'edgelink_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $sql = "INSERT INTO services (title, description, icon) VALUES ('$title', '$description', '$icon')";
    if ($conn->query($sql) === TRUE) {
        header("Location: services.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Service</h1>
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label">Icon (FontAwesome class)</label>
                <input type="text" class="form-control" id="icon" name="icon" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
            <a href="services.php" class="btn btn-secondary">Back to Admin Panel</a>
        </form>
    </div>
</body>
</html>
