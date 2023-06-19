<?php 
session_start(); 
/* Check Login form submitted */	
if(isset($_POST['Submit'])){
	/* Check and assign submitted Username and Password to new variable */
	$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
	$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

	/* Connect to the database */
	$host = "localhost";
	$dbname = "pharmacy";
	$username = "root";
	$password = "";

	$conn = new mysqli($host, $username, $password, $dbname);

	/* Check connection */
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	/* Retrieve password for the given username */
	$stmt = $conn->prepare("SELECT PASSWORD FROM admin_credentials WHERE USERNAME = ?");
	$stmt->bind_param("s", $Username);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	/* Check if username and password match */
	if($row && $row['PASSWORD'] == $Password){
		/* Success: Set session variables and redirect to Protected page  */
		$_SESSION['UserData']['Username']=$Username;
		header("location:home.php");
		exit;
	} else {
		/* Unsuccessful attempt: Set error message */
		$msg="<span style='color:red'>Invalid Login Details</span>";
	}
	$stmt->close();
	$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pharmacy Management - Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card m-auto p-2">
        <div class="card-body">
          <form name="login-form" class="login-form" action="" method="post">
            <div class="logo">
        			<img src="images/prof.jpg" class="profile"/>
        			<h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
        		</div> <!-- logo class -->
				 <?php if(isset($msg)){?>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user text-white"></i><?php echo $msg;?></span>
              </div>
			  <?php } ?>
			  <input name="Username" type="text" class="form-control" placeholder="username" required>
            </div> <!--input-group class -->
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key text-white"></i></span>
              </div>
			  <input name="Password" type="password" class="form-control" placeholder="password" required>
            </div> <!-- input-group class -->
            <div class="form-group">
              <button name="Submit" type="submit" value="Login" class="btn btn-default btn-block btn-custom">Login</button>
			  <input name="Submit" type="submit" value="Login" class="Button3">
            </div>
          </form><!-- form close -->
        </div> <!-- cord-body class -->
        <!-- <div class="card-footer">
          <div class="text-center">
            <a class="text-light" href="#">Forgot password?</a>
          </div>
        </div> cord-footer class -->
      </div> <!-- card class -->
    </div> <!-- container class -->
  </body>
</html>
