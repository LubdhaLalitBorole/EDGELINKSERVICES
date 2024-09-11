 <?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conn.php';
include 'auth.php';

$a = 3;

// Handle form submission
if (isset($_POST['publise'])) {
    // Sanitize and process inputs
    $title = htmlspecialchars(str_replace("&", "and", str_replace("'", "\'", $_POST['title'])), ENT_QUOTES, 'UTF-8');
    $short = htmlspecialchars(str_replace("'", "\'", $_POST['short']), ENT_QUOTES, 'UTF-8');
    $descrip = htmlspecialchars(str_replace("'", "\'", $_POST['descrip']), ENT_QUOTES, 'UTF-8');
    // If 'url' is needed, process it accordingly

    // Handle image upload
    if (isset($_FILES['lis_img']) && $_FILES['lis_img']['name'] != '') {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['lis_img']['name'], PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
            exit();
        }

        if ($_FILES['lis_img']['size'] > 2 * 1024 * 1024) { // 2MB limit
            echo "<script>alert('File size exceeds 2MB.');</script>";
            exit();
        }

        $lis_img = rand() . $_FILES['lis_img']['name'];
        $tempname = $_FILES['lis_img']['tmp_name'];
        $folder = "images/services/" . $lis_img;

        if (!move_uploaded_file($tempname, $folder)) {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        // If editing and no new image is uploaded, retain the existing image
        if (isset($_GET['edit']) && $_GET['edit'] != '') {
            $edit = $_GET['edit'];
            $resultt = mysqli_query($con, "SELECT img FROM services WHERE id = '$edit'");
            $roww = mysqli_fetch_array($resultt);
            $lis_img = $roww["img"];
        } else {
            echo "<script>alert('Image is required.');</script>";
            exit();
        }
    }

    // Get current date
    date_default_timezone_set('Asia/Kolkata');
    $today = date("D d M Y");

    if (isset($_GET['edit']) && $_GET['edit'] != '') {
        // Update existing service
        $edit = $_GET['edit'];
        $stmt = $con->prepare("UPDATE services SET title = ?, short = ?, descrip = ?, img = ?, date = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $title, $short, $descrip, $lis_img, $today, $edit);
        if ($stmt->execute()) {
            echo "<script>alert('Updated Successfully');</script>
                <script>window.location.href = 'add-services.php'</script>";
        } else {
            echo "<script>alert('Update Failed: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        // Insert new service
        $status = 0; // Default status
        $stmt = $con->prepare("INSERT INTO services (title, short, descrip, img, date, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $title, $short, $descrip, $lis_img, $today, $status);
        if ($stmt->execute()) {
            echo "<script>alert('Posted Successfully');</script>
                <script>window.location.href = 'add-services.php'</script>";
        } else {
            echo "<script>alert('Post Failed: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include "title.php"; ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include "topbar.php"; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "sidebar.php"; ?>

    <?php
    // If editing, fetch existing service details
    if (isset($_GET['edit'])) {
        $edit = $_GET['edit'];
        $resultt = mysqli_query($con, "SELECT * FROM services WHERE id = '$edit'");
        if (mysqli_num_rows($resultt) > 0) {
            $roww = mysqli_fetch_array($resultt);
        } else {
            echo "<script>alert('Service not found');</script>
                <script>window.location.href = 'view-services.php'</script>";
            exit();
        }
    }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo isset($edit) ? 'Edit Service' : 'Add Service'; ?></h1>
                    </div>
                    <div class="col-sm-6" style="text-align:right;">
                        <a href="view-services.php" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> View Services</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <div class="form-group">
                                    <label>Enter Title</label>
                                    <input name="title" value="<?php echo isset($roww['title']) ? htmlspecialchars($roww['title']) : ''; ?>" type="text" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>

                            <div class="card-body pad">
                                <label>Short Description</label>
                                <div class="mb-3">
                                    <textarea name="short" placeholder="Short Description" style="width: 100%;" rows="5" cols="23"><?php echo isset($roww['short']) ? htmlspecialchars($roww['short']) : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="card-body pad">
                                <label>Full Description</label>
                                <div class="mb-3">
                                    <textarea name="descrip" class="textarea" placeholder="Place some text here"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo isset($roww['descrip']) ? htmlspecialchars($roww['descrip']) : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="card-header">
                                <div class="form-group">
                                    <label for="exampleInputFile">Select Image <span style="color:red;">(only compressed)</span></label>
                                    <p style="color:red;">Image size 800px x 500px</p>
                                    <?php if (isset($edit)): ?>
                                        <input name="lis_img" type="file">
                                        <p>Current Image: <?php echo htmlspecialchars($roww["img"]); ?></p>
                                    <?php else: ?>
                                        <input name="lis_img" type="file" required>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-header">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <button type="submit" name="publise" class="btn btn-block btn-warning btn-lg">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.col-->
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
$(function () {
    // Summernote
    $('.textarea').summernote()
})
</script>
</body>
</html> 
