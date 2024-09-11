<?php

@include 'config.php';

if (isset($_POST['submit'])) {

    // Check if $conn is a valid mysqli object
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    // Corrected query syntax
    $select = "SELECT * FROM user_form WHERE email = '$email'";

    // Run the query and check for errors
    $result = mysqli_query($conn, $select);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));  // Output the exact error
    }

    // Check number of rows only if the query succeeded
    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Passwords do not match!';
        } else {
            $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')";

            // Run the insert query and check for errors
            if (!mysqli_query($conn, $insert)) {
                die("Insert failed: " . mysqli_error($conn));  // Output the error if the insert fails
            }

            header('location:login_form.php');
        }
    }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/stylelogin.css">

</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>Register Now</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $msg) {
            echo '<span class="error-msg">' . $msg . '</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <select name="user_type">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>
