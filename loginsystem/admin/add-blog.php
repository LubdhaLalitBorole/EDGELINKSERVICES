<?php
error_reporting(0);
include 'conn.php';
include 'auth.php';

$a = 7;
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
        date_default_timezone_set('Asia/Kolkata');
        $today = date("D d M Y");
        $edit = isset($_GET['edit']) ? $_GET['edit'] : '';

        if ($edit != '') {
            $resultt = mysqli_query($con, "SELECT * FROM blog WHERE id=" . $edit);
            $roww = mysqli_fetch_array($resultt);
        }

        if (isset($_POST['publise'])) {
            $title1 = $_POST['title'];
            $title = mysqli_real_escape_string($con, str_replace("'", "\'", $title1));
            $category = mysqli_real_escape_string($con, $_POST['category']);
            $descrip1 = $_POST['descrip'];
            $descrip = mysqli_real_escape_string($con, str_replace("'", "\'", $descrip1));
            $url = mysqli_real_escape_string($con, $_POST['url']);

            if ($_FILES['lis_img']['name'] != '') {
                $lis_img = rand() . $_FILES['lis_img']['name'];
                $tempname = $_FILES['lis_img']['tmp_name'];
                $folder = "images/blog/" . $lis_img;
                $valid_ext = array('png', 'jpeg', 'jpg');
                $file_extension = strtolower(pathinfo($folder, PATHINFO_EXTENSION));

                if (in_array($file_extension, $valid_ext)) {
                    // Compress Image
                    compressImage($tempname, $folder, 60);
                }
            } else {
                $lis_img = $roww["img"];
            }

            if ($edit == '') {
                $insertdata = mysqli_query($con, "INSERT INTO blog(title, category, descrip, img, url, date, status) VALUES('$title', '$category', '$descrip', '$lis_img', '$url', '$today', '0')");
                if ($insertdata) {
                    echo "<script>alert('Posted Successfully');</script>";
                    echo "<script>window.location.href = 'add-blog.php'</script>";
                }
            } else {
                $insertdata = mysqli_query($con, "UPDATE blog SET title='$title', category='$category', descrip='$descrip', img='$lis_img', url='$url', date='$today' WHERE id=" . $edit);
                if ($insertdata) {
                    echo "<script>alert('Updated Successfully');</script>";
                    echo "<script>window.location.href = 'add-blog.php'</script>";
                }
            }
        }

        // Compress image
        function compressImage($source, $destination, $quality)
        {
            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source);

            imagejpeg($image, $destination, $quality);
        }

        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add Blog</h1>
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
                                        <input name="title" value="<?php echo isset($roww["title"]) ? $roww["title"] : ''; ?>" type="text" class="form-control" placeholder="Enter ...">
                                    </div>
                                </div>
                                <div class="card-header">
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select name="category" class="form-control">
                                            <option>Select...</option>
                                            <?php
                                            $location = mysqli_query($con, "SELECT * FROM category");
                                            while ($location_ft = mysqli_fetch_array($location)) {
                                            ?>
                                                <option <?php if (isset($roww["category"]) && $roww["category"] == $location_ft["cat_name"]) {
                                                            echo 'selected';
                                                        } ?> value="<?php echo $location_ft["cat_name"]; ?>">
                                                    <?php echo $location_ft["cat_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body pad">
                                    <label>Enter Description</label>
                                    <div class="mb-3">
                                        <textarea name="descrip" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo isset($roww["descrip"]) ? $roww["descrip"] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Select Img <span style="color:red;">(only compressed)</span></label>
                                        <p style="color:red;">img size 800px x 800px</p>
                                        <input name="lis_img" type="file">
                                        <?php echo isset($roww["img"]) ? $roww["img"] : ''; ?>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <button type="submit" name="publise" class="btn btn-primary btn-lg">Publish Post</button>
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
        $(function() {
            // Summernote
            $('.textarea').summernote()
        })
    </script>
</body>

</html>
