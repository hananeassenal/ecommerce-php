<?php include 'includes/session.php'; ?>
<?php
  if(isset($_SESSION['user'])){
    header('location: cart_view.php');
  }
?>
<?php include 'includes/header.php'; ?>
<body class="bg-primary">

<div class="login-box">
  	<?php
      if(isset($_SESSION['error'])){
        echo "
          <div class='alert alert-danger text-center'>
            <p>".$_SESSION['error']."</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }
      if(isset($_SESSION['success'])){
        echo "
          <div class='alert alert-success text-center'>
            <p>".$_SESSION['success']."</p> 
          </div>
        ";
        unset($_SESSION['success']);
      }
    ?>
  	<div class="login-box-body shadow-lg p-5 rounded-lg">
    	<p class="login-box-msg text-center text-white h3">Welcome Back! Please Sign In</p>

    	<form action="verify.php" method="POST">
      		<div class="form-group mb-4">
        		<input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
        		<div class="input-group-append">
        			<span class="input-group-text"><i class="fa fa-envelope"></i></span>
        		</div>
      		</div>
          <div class="form-group mb-4">
            <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-lock"></i></span>
            </div>
          </div>
      		<div class="row">
    			<div class="col-12">
          			<button type="submit" class="btn btn-dark btn-lg btn-block" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
      		</div>
    	</form>

      <!-- Links section -->
      <div class="text-center mt-4">
        <a href="password_forgot.php" class="text-muted">Forgot your password?</a><br>
        <a href="signup.php" class="text-muted">Create a new account</a><br>
        <a href="index.php" class="text-muted"><i class="fa fa-home"></i> Back to Home</a>
      </div>
  	</div>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>
