<?php
$conn = new mysqli('localhost', 'root', '', 'edgelink_db');

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $sql = "UPDATE services SET title='$title', description='$description', icon='$icon' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM services WHERE id=$id";
    $result = $conn->query($sql);
    $service = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Service</h1>
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $service['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $service['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label">Icon (FontAwesome class)</label>
                <input type="text" class="form-control" id="icon" name="icon" value="<?php echo $service['icon']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Service</button>
            <a href="services.php" class="btn btn-secondary">Back to Admin Panel</a>
        </form>
    </div>
</body>
</html>
