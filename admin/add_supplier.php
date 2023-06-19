<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Add Suppliers</title>
  </head>
<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>
<br><br>
<div class = "rightbox">
<form action="add_supplier.php" method="post">
  <label for="Sup_ID">Supplier ID:</label><br>
  <input type="text" id="Sup_ID" name="Sup_ID"><br>
  <label for="Sup_Name">Name:</label><br>
  <input type="text" id="Sup_Name" name="Sup_Name"><br>
  <label for="Sup_Mail">Email:</label><br>
  <input type="email" id="Sup_Mail" name="Sup_Mail"><br>
  <label for="Sup_Phone">Phone:</label><br>
  <input type="number" id="Sup_Phone" name="Sup_Phone"><br>
  <label for="Sup_Add">Address:</label><br>
  <input type="text" id="Sup_Add" name="Sup_Add"><br><br>
  <input type="submit" value="Submit">
</form> 

<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $Sup_ID = $_POST["Sup_ID"];
  $Sup_Name = $_POST["Sup_Name"];
  $Sup_Mail = $_POST["Sup_Mail"];
  $Sup_Phone = $_POST["Sup_Phone"];
  $Sup_Add = $_POST["Sup_Add"];

  // Validate the form data
  $error_msg = "";
  if (empty($Sup_ID)) {
    $error_msg .= "Supplier ID is required<br>";
  }
  if (empty($Sup_Name)) {
    $error_msg .= "Name is required<br>";
  }
  if (empty($Sup_Mail)) {
    $error_msg .= "Email is required<br>";
  }
  if (empty($Sup_Phone)) {
    $error_msg .= "Phone is required<br>";
  } elseif (!is_numeric($Sup_Phone)) {
    $error_msg .= "Phone must be a number<br>";
  }
  if (empty($Sup_Add)) {
    $error_msg .= "Address is required<br>";
  }

// If there are no errors, insert the new supplier into the database
if (empty($error_msg)) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Insert the new supplier into the database
  $sql = "INSERT INTO SUPPLIERS (Sup_ID, Sup_Name, Sup_Mail, Sup_Phone, Sup_Add)
          VALUES ('$Sup_ID', '$Sup_Name', '$Sup_Mail', '$Sup_Phone', '$Sup_Add')";
  if (mysqli_query($conn, $sql)) {
    echo "<center><h2>New supplier added successfully</center></h2>";
  } else {
    echo "<center><h2>Error: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
  }

  // Close the connection
  mysqli_close($conn);
}
}
?>
</div>