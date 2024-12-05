<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'includes/session.php';

if (isset($_POST['signup'])) {
    // Capture user input and sanitize
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;

    // Verify reCAPTCHA
    if (!isset($_SESSION['captcha'])) {
        require('recaptcha/src/autoload.php');        
        $recaptcha = new \ReCaptcha\ReCaptcha('6LcxXmIaAAAAAFSY6wjaHDl65lmpTyXu-iBYBhp3');
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                          ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if (!$resp->isSuccess()) {
            $_SESSION['error'] = 'Please answer recaptcha correctly';
            header('location: signup.php');  
            exit();    
        } else {
            $_SESSION['captcha'] = time() + (10 * 60);
        }
    }

    // Password validation
    if ($password !== $repassword) {
        $_SESSION['error'] = 'Passwords do not match';
        header('location: signup.php');
        exit();
    }

    // Database connection
    $conn = $pdo->open();

    // Check if email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch();
    if ($row['numrows'] > 0) {
        $_SESSION['error'] = 'Email is already taken';
        header('location: signup.php');
        exit();
    }

    // Prepare password and other fields
    $now = date('Y-m-d');
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Generate activation code
    $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = substr(str_shuffle($set), 0, 12);

    try {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) 
                                VALUES (:email, :password, :firstname, :lastname, :code, :now)");
        $stmt->execute(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'code' => $code, 'now' => $now]);
        $userid = $conn->lastInsertId();

        // Prepare the email message
        $message = "
            <h2>Thank you for Registering.</h2>
            <p>Your Account:</p>
            <p>Email: " . $email . "</p>
            <p>Password: " . $password . "</p>
            <p>Please click the link below to activate your account.</p>
            <a href='http://localhost/ecommerce/activate.php?code=" . $code . "&user=" . $userid . "'>Activate Account</a>
        ";

        // Load PHPMailer
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();    
            $mail->Host = 'smtp.gmail.com';                    
            $mail->SMTPAuth = true;    
            $mail->Username = 'hananeassendal.info@gmail.com';     
            $mail->Password = 'xrjc lyor exlw ltep';     // Updated with your app password
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                         
            $mail->SMTPSecure = 'ssl';   
            $mail->Port = 465; 

            $mail->setFrom('hananeassendal.info@gmail.com', 'Your Website Name');
            $mail->addAddress($email);              
            $mail->addReplyTo('hananeassendal.info@gmail.com');
            
            // Content
            $mail->isHTML(true);                                    
            $mail->Subject = 'ECommerce Site Sign Up';
            $mail->Body = $message;

            $mail->send();

            // Unset session variables
            unset($_SESSION['firstname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['email']);

            $_SESSION['success'] = 'Account created. Check your email to activate.';
            header('location: signup.php');

        } catch (Exception $e) {
            $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            header('location: signup.php');
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        header('location: signup.php');
    }

    $pdo->close();
} else {
    $_SESSION['error'] = 'Fill up the signup form first';
    header('location: signup.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-primary">
<div class="signup-container">
    <div class="signup-form">
        <p class="text-center text-primary h3">Create an Account</p>

        <?php
        if (isset($_SESSION['error'])) {
            echo "
              <div class='alert alert-danger text-center'>
                <p>" . $_SESSION['error'] . "</p>
              </div>
            ";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "
              <div class='alert alert-success text-center'>
                <p>" . $_SESSION['success'] . "</p>
              </div>
            ";
            unset($_SESSION['success']);
        }
        ?>

        <form action="signup.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repassword" placeholder="Re-enter Password" required>
            </div>

            <!-- reCAPTCHA -->
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="YOUR_GOOGLE_RECAPTCHA_SITE_KEY"></div>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
            </div>

            <div class="text-center">
                <p class="terms-link">By signing up, you agree to our <a href="#">Terms of Service</a></p>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js"></script>

</body>
</html>