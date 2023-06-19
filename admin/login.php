<?php session_start(); /* Starts the session */
	
	/* Check Login form submitted */	
	if(isset($_POST['Submit'])){
		/* Define username and associated password array */
		$logins = array('shreesha' => 'shreesha', 'admin' => 'admin');
		
		/* Check and assign submitted Username and Password to new variable */
		$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
		
		/* Check Username and Password existence in defined array */		
		if (isset($logins[$Username]) && $logins[$Username] == $Password){
			/* Success: Set session variables and redirect to Protected page  */
			$_SESSION['UserData']['Username']=$logins[$Username];
			header("location:index.php");
			exit;
		} else {
			/*Unsuccessful attempt: Set error message */
			$msg="<span style='color:red'>Invalid Login Details</span>";
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrator login</title>
</head>
<body style="background-image: url('./img/medi.jpg');">
<div id="Frame0">
  <center><h1>Administrator login</h1><h1> <a href="../index.php">Home</a></h1></center>
</div>
<br><br><br><br><br>
<form action="" method="post" name="Login_Form">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" align="left" valign="top"><h3>Login</h3></td>
    </tr>
    <tr>
      <td align="right" valign="top">Username</td>
      <td><input name="Username" type="text" class="Input"></td>
    </tr>
    <tr>
      <td align="right">Password</td>
      <td><input name="Password" type="password" class="Input"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" value="Login" class="Button3"></td>
    </tr>
  </table>
</form>
</body>
</html>
<style type="text/css">
	body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333;
	background-color: #FFF;
}
a {
	-moz-user-select: none;
	color: #1155CC !important;
	font-family: "verdana", "Helvetica Neue", Helvetica, Arial, sans-serif;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
h3 {
	margin:0;
	padding:10px 5px 10px 5px;
}
#Frame0 {
	background-color: #00ffff;
	margin: 30px auto auto;
	padding: 10px;
	width: 750px;
	border: 1px solid #EEE;
}
.Button3 {
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
	cursor: pointer;
	display: inline-block;
	font-size: 11px;
	font-weight: 700;
	line-height: 23px;
	margin-right: 2px;
	min-width: 40px;
	padding: 0 16px;
	text-align: center;
	-moz-user-select: none;
	color: #FFFFFF;
	-moz-box-shadow:inset 0 1px 0 #529E21, inset 1px 0 0 #4A911C, inset -1px 0 0 #4A911C, inset 0 -1px 0 #3D7F12, inset 0 2px 0 rgba(255, 255, 255, 0.3), inset 0 0 4px rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.3);
	-webkit-box-shadow:inset 0 1px 0 #529E21, inset 1px 0 0 #4A911C, inset -1px 0 0 #4A911C, inset 0 -1px 0 #3D7F12, inset 0 2px 0 rgba(255, 255, 255, 0.3), inset 0 0 4px rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.3);
	box-shadow:inset 0 1px 0 #529E21, inset 1px 0 0 #4A911C, inset -1px 0 0 #4A911C, inset 0 -1px 0 #3D7F12, inset 0 2px 0 rgba(255, 255, 255, 0.3), inset 0 0 4px rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.3);
	background:#6dbd45;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.2, #6dbd45), color-stop(1, #51a326));
	background:-moz-linear-gradient(center top, #6dbd45 20%, #51a326 100%);
	border:0;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	border-radius:3px;
	padding: 3px 10px;
	text-align:center;
	overflow:hidden;
	min-width:70px;
}
.Button1:hover {
	text-decoration: none;
}
.button3:active {
	background:#6dbd45;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.2, #5EA534), color-stop(1, #519327));
	background:-moz-linear-gradient(center top, #5EA534 20%, #519327 100%);
}
.Button3:active, .a:active {
	position: relative;
	top: 1px;
}
.Input {
	background-color: #FFFFFF;
	border-color: #A0A0A0 #B9B9B9 #B9B9B9;
	border-style: solid;
	border-width: 2px;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
	font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
	font-size: 14px;
	margin: 2;
	padding: 8px;
	width: 200px;
}
.Table {
	font-family: verdana, Helvetica, sans-serif;
	font-size: 20px;
	color: #333;
	background-color: #E4E4E4;
}
.Table td {
	background-color: #F8F8F8;
}

</style>