<?php
include('conn.php');
session_start();

// Check if connection is successful
if (!$con) {
    die("Connection to database failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Use the valid $con connection object
    $ad_email = mysqli_real_escape_string($con, $_POST['ad_email']);
    $ad_pass = mysqli_real_escape_string($con, $_POST['ad_pass']);

    // Execute query
    $check = mysqli_query($con, "SELECT * FROM admin WHERE ad_email='$ad_email' AND ad_password='$ad_pass'");

    if ($check) { // Check if query executed successfully
        $check_fetch = mysqli_fetch_array($check);
        
        // Check if ad_id is set in the result
        if (isset($check_fetch['ad_id']) && $check_fetch['ad_id'] != '') {
            $_SESSION['ad_id'] = $check_fetch['ad_id'];
            header('location:index.php');
            exit(); // Ensure the script stops after redirection
        } else {
            echo "<p style='color:red;text-align:center;'>Invalid email or password.</p>";  // Display an error message if login fails
        }
    } else {
        echo "<p style='color:red;text-align:center;'>Query failed: " . mysqli_error($con) . "</p>"; // Error handling for failed query
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex" />
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>Admin</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="email" name="ad_email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="ad_pass" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
        <div class="row pt-1">
          <div class="col-12 text-center">
            <div class="icheck-primary">
              <a href="forgot-password.php">Forgot Password</a>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>