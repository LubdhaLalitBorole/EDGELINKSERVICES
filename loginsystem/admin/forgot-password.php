<?php
require 'php-cms/vendor/autoload.php'; // Adjusted path to include the Composer autoloader
include('php-cms/admin/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $from = 'forgot@wiseutilities.com';
    $subject = 'Forgot Password';
    $ad_email = $_POST['ad_email'];

    // Check if the email exists in the database
    $check = mysqli_query($con, "SELECT * FROM admin WHERE ad_email='$ad_email'");
    $check_fetch = mysqli_fetch_array($check);

    if ($check_fetch['ad_id'] != '') {
        $id = $check_fetch['ad_id'];

        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        try {
            //Server settings
            $mail->isSMTP();                                          // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
            $mail->Username   = 'your-email@gmail.com';                // SMTP username (replace with your email)
            $mail->Password   = 'your-email-password';                 // SMTP password (replace with your email password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                   // TCP port to connect to

            //Recipients
            $mail->setFrom($from, 'Wise Utilities');
            $mail->addAddress($ad_email);                              // Add recipient

            // Content
            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = '<html><body>
                                <h2>Password Reset Request</h2>
                                <p>Please click the link below to reset your password:</p>
                                <p><a href="https://' . $_SERVER['HTTP_HOST'] . '/admin/password-reset.php?m=' . $id . '">Reset Password</a></p>
                              </body></html>';
            $mail->AltBody = 'Please click the link to reset your password: https://' . $_SERVER['HTTP_HOST'] . '/admin/password-reset.php?m=' . $id;

            $mail->send();
            echo "Please verify your email and change your password.";
        } catch (Exception $e) {
            echo "Unable to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Unable to send email. Please try again.';
    }
}
?>
