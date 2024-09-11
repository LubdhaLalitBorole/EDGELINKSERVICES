<?php
error_reporting(E_ALL); // Enable error reporting for debugging
include 'conn.php';
include 'auth.php';

// Deleting a category
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input
    $query_delete = "DELETE FROM category WHERE id=?";
    $stmt = $con->prepare($query_delete);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>alert('Deleted Successfully');</script>";
    echo "<script>window.location.href = 'add-category.php'</script>";
}

// Fetching category details for editing
$edit = isset($_GET['edit']) ? intval($_GET['edit']) : null;
$roww = [];
if ($edit) {
    $stmt = $con->prepare("SELECT * FROM category WHERE id=?");
    $stmt->bind_param("i", $edit);
    $stmt->execute();
    $resultt = $stmt->get_result();
    $roww = $resultt->fetch_assoc();
}

// Handling form submission for adding/updating category
if (isset($_POST['add'])) {
    $name = $_POST['cat_name'];
    
    if ($edit) {
        // Update category
        $stmt = $con->prepare("UPDATE category SET cat_name=? WHERE id=?");
        $stmt->bind_param("si", $name, $edit);
        $stmt->execute();
        echo "<script>alert('Updated Successfully');</script>";
    } else {
        // Insert new category
        $stmt = $con->prepare("INSERT INTO category (cat_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        echo "<script>alert('Added Successfully');</script>";
    }

    echo "<script>window.location.href = 'add-category.php'</script>";
}

// Fetching all categories for display
$location = $con->query("SELECT * FROM category");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include "title.php"; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include "topbar.php"; ?>
  <?php include "sidebar.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Category</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-5">
          <form action="" method="post">
            <div class="card card-outline card-info">
              <div class="card-header">
                <div class="form-group">
                  <label>Enter Category Name</label>
                  <input type="text" name="cat_name" value="<?php echo htmlspecialchars($roww["cat_name"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <button type="submit" name="add" class="btn btn-block btn-primary btn-lg">Add</button>
            </div>
          </form>
        </div>
        <div class="col-md-7">
          <div class="card card-outline card-info">
            <div class="card-header">
              <div class="form-group">
                <label>All Categories</label>
              </div>
            </div>
            <div class="card-header">
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($location_ft = $location->fetch_assoc()) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($location_ft["cat_name"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                          <a href="add-category.php?edit=<?php echo $location_ft["id"]; ?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                          <a href="add-category.php?delete_id=<?php echo $location_ft["id"]; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include "footer.php"; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    $('.textarea').summernote()
  })
</script>
</body>
</html>
